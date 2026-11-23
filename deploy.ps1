$ErrorActionPreference = "Stop"

$projectDir = Split-Path -Parent $MyInvocation.MyCommand.Path
$ngrokUrl = ""

Write-Host "=== Star Cake - ngrok Deploy ===" -ForegroundColor Cyan

if (-not (Get-Command php -ErrorAction SilentlyContinue)) {
    Write-Error "php not found in PATH."
    exit 1
}
if (-not (Get-Command ngrok -ErrorAction SilentlyContinue)) {
    Write-Error "ngrok not found in PATH."
    exit 1
}

$portInUse = Get-NetTCPConnection -LocalPort 8000 -State Listen -ErrorAction SilentlyContinue
if ($portInUse) {
    Write-Host "Laravel server already running on :8000 (reusing)." -ForegroundColor Yellow
}
else {
    Write-Host "Starting Laravel dev server..." -ForegroundColor Green
    Start-Process -FilePath "php" -ArgumentList "artisan serve --host=127.0.0.1 --port=8000" -WorkingDirectory $projectDir -WindowStyle Normal
}

$ngrokRunning = Get-NetTCPConnection -LocalPort 4040 -State Listen -ErrorAction SilentlyContinue
if ($ngrokRunning) {
    Write-Host "ngrok already running (reusing tunnel)." -ForegroundColor Yellow
}
else {
    Write-Host "Starting ngrok tunnel..." -ForegroundColor Green
    Start-Process -FilePath "ngrok" -ArgumentList "http 8000" -WorkingDirectory $projectDir -WindowStyle Normal
}

Write-Host "Waiting for tunnel..." -ForegroundColor Green
for ($i = 0; $i -lt 30; $i++) {
    Start-Sleep -Seconds 1
    try {
        $resp = Invoke-RestMethod -Uri "http://127.0.0.1:4040/api/tunnels" -TimeoutSec 2
        if ($resp.tunnels.Count -gt 0) {
            $ngrokUrl = $resp.tunnels[0].public_url
            break
        }
    }
    catch { }
}

if ($ngrokUrl) {
    Write-Host "`nDeployed!" -ForegroundColor Green
    Write-Host "Public URL : $ngrokUrl" -ForegroundColor Cyan
    Write-Host "ngrok UI   : http://127.0.0.1:4040" -ForegroundColor Cyan
    Start-Process $ngrokUrl
}
else {
    Write-Host "Could not detect tunnel URL. Open http://127.0.0.1:4040 manually." -ForegroundColor Yellow
}
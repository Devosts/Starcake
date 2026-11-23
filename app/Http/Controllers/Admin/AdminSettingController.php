<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function __invoke(Request $request)
    {
        $records = Setting::orderBy('group')->orderBy('key')->get();

        return view('admin.settings', ['setting_rows' => $records]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'settings' => ['nullable', 'array'],
        ]);

        $values = (array) ($data['settings'] ?? []);

        foreach (Setting::where('type', 'boolean')->pluck('key') as $key) {
            $values[$key] = $values[$key] ?? '0';
        }

        foreach ($values as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => $request->input("groups.$key", 'general')]
            );
            Setting::forget($key);
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}

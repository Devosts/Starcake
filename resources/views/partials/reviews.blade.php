@php
    $reviews = $product->reviews()->where('is_approved', true)->latest()->get();
    $avg = $reviews->avg('rating');
@endphp

@if($reviews->isNotEmpty())
    <div class="space-y-4">
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-1">
                @for($r = 1; $r <= 5; $r++)
                    @if($r <= round($avg))
                        <x-icon name="star" solid="true" class="h-4 w-4 text-amber-400" />
                    @else
                        <x-icon name="star" class="h-4 w-4 text-surface-300" />
                    @endif
                @endfor
            </div>
            <span class="text-sm text-surface-500">{{ number_format($avg, 1) }} / 5 · {{ $reviews->count() }} ulasan</span>
        </div>

        @foreach($reviews as $review)
            <div class="flex gap-3">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-surface-200 text-xs font-bold text-primary">
                    @if($review->user && $review->user->avatar)
                        <img src="{{ asset('storage/' . $review->user->avatar) }}" alt="{{ $review->user->name }}"
                            class="h-8 w-8 rounded-full object-cover" />
                    @else
                        {{ strtoupper(mb_substr($review->user->name ?? 'A', 0, 1)) }}
                    @endif
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-medium text-surface-700">{{ $review->user ? $review->user->name : 'Pengunjung' }}</span>
                        <div class="flex items-center gap-0.5">
                            @for($r = 1; $r <= 5; $r++)
                                @if($r <= $review->rating)
                                    <x-icon name="star" solid="true" class="h-3 w-3 text-amber-400" />
                                @else
                                    <x-icon name="star" class="h-3 w-3 text-surface-300" />
                                @endif
                            @endfor
                        </div>
                    </div>
                    @if($review->comment)
                        <p class="mt-1 text-sm text-surface-600">{{ $review->comment }}</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@else
    <p class="text-sm text-surface-500">Belum ada ulasan. Jadilah ulasan pertama!</p>
@endif

@auth
    <form method="POST" action="{{ route('product.review', $product->slug) }}" class="mt-6">
        @csrf
        <h4 class="font-medium text-surface-800 mb-2">Tulis Ulasan</h4>
        <div class="mb-2 flex items-center gap-1">
            @for($r = 5; $r >= 1; $r--)
                <input type="radio" name="rating" value="{{ $r }}" id="rating{{ $r }}" class="peer sr-only" required />
                <label for="rating{{ $r }}" class="cursor-pointer">
                    <x-icon name="star" solid="true"
                        class="h-5 w-5 text-surface-300 peer-checked:text-amber-400" />
                </label>
            @endfor
        </div>
        <p class="text-xs text-surface-500 mb-2">Klik bintang untuk memberi rating.</p>
        <textarea name="comment" placeholder="Cerita tentang pengalamanmu..."
            class="w-full rounded-xl border border-surface-300 px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary/30"></textarea>
        <button type="submit" class="btn-primary mt-3 w-max">Kirim Ulasan</button>
    </form>
@endauth

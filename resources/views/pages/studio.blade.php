<?php

declare(strict_types=1);

use App\Services\ImageProcessor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Title;
use App\Enums\AllowedFormat;
use App\Enums\AllowedAspectRatio;
use App\Enums\AllowedWatermarkPosition;
use App\Enums\AllowedRotateValue;
use Livewire\Component;
use Mary\Traits\Toast;
use Livewire\WithFileUploads;

new #[Title('studio')] class extends Component {
    use Toast, WithFileUploads;

    private const int MAX_FILES = 30;

    #[Validate(['photos.*' => 'required|image|mimes:png,jpg,jpeg,webp|mimetypes:image/png,image/jpeg,image/webp|max:5120'])]
    public array $photos = [];

    #[Validate('required|int|gte:10|lte:100')]
    public int $quality = 80;

    #[Validate('required|int|gte:50|lte:5000')]
    public ?int $width = 1200;

    #[Validate('required|string|in_array:AllowedFormat::values()')]
    public string $format;

    #[Validate('required|string|in_array:AllowedFormat::values()')]
    public string $ratio;

    #[Validate('required|string|in_array:AllowedRotateValue::values()')]
    public int $rotate = 0;

    #[Validate('optional|bool')]
    public bool $flipH = false;

    #[Validate('optional|bool')]
    public bool $flipV = false;

    #[Validate('optional|string|in_array:AllowedWatermarkPosition::values()')]
    public string $position = 'bottom-right';

    public function mount()
    {
        $this->format = AllowedFormat::WEBP->value;
        $this->ratio = AllowedAspectRatio::RATIO_1_1->value;
    }

    public int $selected = 0;

    #[Locked]
    public ?string $batch = null;

    public int $sel = 0;
    public array $results = [];
    public bool $grayscale = false;
    public int $blur = 0;
    public int $sharpen = 0;
    public int $brightness = 0;
    public int $contrast = 0;
    public bool $watermark = false;
    public int $opacity = 60;

    public function select(int $index): void
    {
        $this->selected = $index;
    }

    public function exception($e, $stopPropagation)
    {
        if ($e instanceof NotFoundException) {
            $this->notify('Post is not found');
            $stopPropagation();
        }
    }

    public function optimize() {}
};
?>

<div>
		<h2 class="font-display mb-6 text-3xl font-extrabold tracking-tight">{{ config('app.name', 'studio') }}</h2>
		<div class="grid gap-6 lg:grid-cols-[1fr_400px]">
				<div class="space-y-6">

						<div class="uploader">
								<x-file wire:model="photos" accept="image/jpeg,image/png,image/webp,.jpg,.jpeg,.png,.webp"
										change-text="upload here">
										<div class="flex flex-col justify-center gap-2">
												<p class="font-display text-2xl font-extrabold">Drop image here</p>
												<p class="text-base-content/60 mt-1 text-sm">
														or click to browse. JPG, PNG, WebP and JPEG, up to 5 MB.
												</p>
										</div>
								</x-file>
						</div>

						@error('photos')
								<x-alert title="{{ $message }}" icon="o-exclamation-triangle" class="alert-error" />
						@enderror
						@error('photos.*')
								<x-alert title="{{ $message }}" icon="o-exclamation-triangle" class="alert-error" />
						@enderror

						@if ($photos)
								<div class="border-base-300 bg-base-100 space-y-4 rounded-[28px] border p-4">
										<div class="bg-base-200 grid place-items-center rounded-2xl p-3">
												<div class="relative overflow-hidden rounded-xl shadow-lg"
														style="aspect-ratio:{{ $ratioValue }}; width:min(100%, {{ 440 * $ratioValue }}px)">
														<img src="{{ $photos[$sel]->temporaryUrl() }}" alt=""
																class="{{ $ratio === 'original' ? 'object-contain' : 'object-cover' }} size-full"
																style="filter:brightness({{ 1 + $brightness / 100 }}) contrast({{ 1 + $contrast / 100 }}) grayscale({{ $grayscale ? 1 : 0 }}) blur({{ $blur / 12 }}px);
                                        transform:rotate({{ $rotate }}deg) scale({{ $flipH ? -1 : 1 }},{{ $flipV ? -1 : 1 }})">
														@if ($watermark)
																<div class="pointer-events-none absolute inset-0 flex p-4"
																		style="justify-content:{{ str_contains($position, 'left') ? 'flex-start' : (str_contains($position, 'right') ? 'flex-end' : 'center') }};
                                            align-items:{{ str_contains($position, 'top') ? 'flex-start' : (str_contains($position, 'bottom') ? 'flex-end' : 'center') }};
                                            opacity:{{ $opacity / 100 }}">
																		<span class="font-display rounded-md bg-white/90 px-3 py-1 text-sm font-extrabold text-black">Your
																				logo</span>
																</div>
														@endif
												</div>
										</div>

										<div class="flex gap-2 overflow-x-auto pb-1">
												@foreach ($photos as $i => $photo)
														<div wire:key="thumb-{{ $i }}" class="relative shrink-0">
																<button wire:click="$set('sel', {{ $i }})"
																		class="{{ $sel === $i ? 'ring-2 ring-primary' : 'opacity-70 hover:opacity-100' }} block size-16 overflow-hidden rounded-xl">
																		<img src="{{ $photo->temporaryUrl() }}" alt="" class="size-full object-cover">
																</button>
																<button wire:click="removePhoto({{ $i }})" aria-label="Remove"
																		class="bg-base-content text-base-200 absolute -right-1 -top-1 grid size-5 place-items-center rounded-full text-xs">×</button>
														</div>
												@endforeach
										</div>

										<dl class="bg-base-300 grid grid-cols-2 gap-px overflow-hidden rounded-2xl text-sm sm:grid-cols-4">
												@php $cur = $photos[$sel]; @endphp
												<div class="bg-base-100 p-3">
														<dt class="text-base-content/70">File</dt>
														<dd class="truncate font-semibold">{{ $cur->getClientOriginalName() }}</dd>
												</div>
												<div class="bg-base-100 p-3">
														<dt class="text-base-content/70">Original size</dt>
														<dd class="truncate font-semibold tabular-nums">{{ Number::fileSize($cur->getSize()) }}</dd>
												</div>
												<div class="bg-base-100 p-3">
														<dt class="text-base-content/70">Format</dt>
														<dd class="truncate font-semibold tabular-nums">{{ strtoupper($format) }}</dd>
												</div>
												<div class="bg-base-100 p-3">
														<dt class="text-base-content/70">Quality</dt>
														<dd class="truncate font-semibold tabular-nums">{{ $quality }}%</dd>
												</div>
										</dl>
								</div>
						@endif

						@if ($results)
								@php
										$totalBefore = collect($results)->sum('before.size');
										$totalAfter = collect($results)->sum('after.size');
								@endphp

								<div class="border-base-300 bg-base-100 rounded-[28px] border p-5">
										<div class="flex flex-wrap items-end justify-between gap-3">
												<div>
														<h3 class="font-display text-2xl font-extrabold">Optimized</h3>
														<p class="text-base-content/70 text-sm">
																{{ count($results) }} images, {{ Number::fileSize($totalBefore) }} down to
																{{ Number::fileSize($totalAfter) }}
														</p>
												</div>
												<p class="font-display text-success text-5xl font-extrabold tabular-nums">
														-{{ round(100 - ($totalAfter / max($totalBefore, 1)) * 100) }}%
												</p>
										</div>

										<div class="divide-base-300 mt-4 divide-y">
												@foreach ($results as $i => $r)
														@php $saved = round(100 - $r['after']['size'] / max($r['before']['size'], 1) * 100); @endphp
														<div class="flex items-center gap-3 py-3" wire:key="result-{{ $i }}">
																<img src="{{ $photos[$i]->temporaryUrl() }}" alt="" class="size-11 rounded-lg object-cover">
																<div class="min-w-0 flex-1">
																		<p class="truncate font-medium">{{ $r['name'] }}</p>
																		<p class="text-base-content/70 text-xs tabular-nums">
																				{{ $r['before']['width'] }}×{{ $r['before']['height'] }} at
																				{{ Number::fileSize($r['before']['size']) }}, now {{ Number::fileSize($r['after']['size']) }}
																		</p>
																</div>
																<span
																		class="bg-success/15 text-success rounded-full px-2.5 py-1 text-xs font-semibold tabular-nums">-{{ $saved }}%</span>
														</div>
												@endforeach
										</div>

										<x-button label="Download ZIP" wire:click="download" spinner="download"
												class="btn-neutral mt-4 w-full rounded-full" />
								</div>
						@endif
				</div>

				<div class="lg:sticky lg:top-20 lg:self-start" x-data="{ tab: 'output' }">
						<div class="border-base-300 bg-base-100 rounded-[28px] border p-4">

								<div class="bg-base-200 mb-4 grid grid-cols-5 gap-1 rounded-2xl p-1 text-xs font-semibold" role="tablist">
										@foreach (['output' => 'Output', 'crop' => 'Crop', 'rotate' => 'Rotate', 'filters' => 'Filters', 'mark' => 'Mark'] as $key => $label)
												<button type="button" role="tab" x-on:click="tab = '{{ $key }}'"
														x-bind:class="tab === '{{ $key }}' && 'bg-base-100 shadow'"
														class="text-base-content/70 truncate rounded-xl py-2 transition">{{ $label }}</button>
										@endforeach
								</div>

								<div class="min-h-62.5 space-y-5">

										<div x-show="tab === 'output'" x-cloak class="space-y-5">
												<div>
														<p class="mb-2 text-sm font-semibold">Format</p>
														<div class="border-base-300 flex gap-1 rounded-xl border p-1">
																@foreach (AllowedFormat::values() as $f)
																		<button type="button" wire:click="$set('format', '{{ $f }}')"
																				class="{{ $format === $f ? 'bg-primary text-primary-content' : 'text-base-content/70 hover:text-base-content' }} flex-1 rounded-lg py-1.5 text-sm font-medium transition">
																				{{ strtoupper($f) }}
																		</button>
																@endforeach
														</div>
												</div>

												<livewire:ui.range title="quality" :rangeValue="$quality" />

												<label class="block text-sm font-semibold">
														Max width in px (min: 50, max: 5000)
														<input type="number" min="50" max="5000" wire:model="width"
																class="input input-bordered mt-1 w-full font-normal">
														<span class="text-base-content/70 mt-1 block text-xs font-normal">
																Images only shrink, never enlarge.
														</span>
												</label>
										</div>

										<div x-show="tab === 'crop'" x-cloak>
												<p class="mb-2 text-sm font-semibold">Aspect ratio, centered crop</p>
												<div class="border-base-300 flex justify-center gap-1 rounded-xl border p-1">
														@forelse (AllowedAspectRatio::options() as $v => $label)
																<button type="button" wire:click="$set('ratio', '{{ $v }}')"
																		class="{{ $ratio === $v ? 'bg-primary text-primary-content' : 'text-base-content/70 hover:text-base-content' }} flex-1 rounded-lg py-1.5 text-sm font-medium transition">
																		{{ $label }}
																</button>
														@empty
																<p class="text-base-content/70 p-1 capitalize">not available</p>
														@endforelse
												</div>
										</div>

										<div x-show="tab === 'rotate'" x-cloak class="space-y-5">
												<div>
														<p class="mb-2 text-sm font-semibold">Rotate clockwise</p>
														<div class="border-base-300 flex gap-1 rounded-xl border p-1">
																@foreach (AllowedRotateValue::options() as $v)
																		<button type="button" wire:click="$set('rotate', {{ $v }})"
																				class="{{ $rotate === $v ? 'bg-primary text-primary-content' : 'text-base-content/70 hover:text-base-content' }} flex-1 rounded-lg py-1.5 text-sm font-medium transition">
																				{{ $v }}°
																		</button>
																@endforeach
														</div>
												</div>
												<x-toggle label="Flip horizontal" wire:model.live="flipH" right />
												<x-toggle label="Flip vertical" wire:model.live="flipV" right />
										</div>

										<div x-show="tab === 'filters'" x-cloak class="space-y-4">
												<x-toggle label="Grayscale" wire:model.live="grayscale" right />
												@foreach ([['brightness', 'Brightness', -100, 100], ['contrast', 'Contrast', -100, 100], ['sharpen', 'Sharpen', 0, 50], ['blur', 'Blur', 0, 50]] as [$field, $label, $min, $max])
														<livewire:ui.range :title="$label" :rangeValue="$field" :min="$min" :max="$max" />
												@endforeach
										</div>

										<div x-show="tab === 'mark'" x-cloak class="space-y-5">
												<x-toggle label="Add watermark" wire:model.live="watermark" right />
												@if ($watermark)
														<div>
																<p class="mb-2 text-sm font-semibold">Position</p>
																<div class="grid w-40 grid-cols-3 gap-1">
																		@foreach (AllowedWatermarkPosition::options() as $g)
																				<button type="button" wire:click="$set('position', '{{ $g }}')"
																						aria-label="{{ $g }}"
																						class="{{ $position === $g ? 'bg-primary' : 'bg-base-300' }} h-9 rounded-lg transition"></button>
																		@endforeach
																</div>
														</div>
														<livewire:ui.range title="opacity" :rangeValue="$opacity" min="5" max="100" />
												@endif
										</div>
								</div>

								<x-button wire:click="optimize" spinner="optimize" :disabled="!$photos"
										class="btn-primary mt-5 w-full rounded-full">
										{{ $photos ? 'Optimize ' . count($photos) . ' ' . Str::plural('image', count($photos)) : 'Add images to start' }}
								</x-button>
						</div>
				</div>
		</div>
</div>

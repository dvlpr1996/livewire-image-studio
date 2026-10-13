@props(['text' => 'Loading…', 'target' => null])

<div class="flex justify-center">
		<p wire:loading @if ($target) wire:target="{{ $target }}" @endif class="text-warning">
				{{ $text }}
		</p>
</div>

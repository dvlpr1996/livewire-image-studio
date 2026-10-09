<?php

declare(strict_types=1);

use Livewire\Component;

new class extends Component {
    public string $title;
    public string|int $rangeValue;
    public int $min = 10;
    public int $max = 100;
};
?>

<div>
		<div class="mb-1 flex justify-between text-sm">
				<span class="font-semibold capitalize">{{ $title }}</span>
				<span class="text-base-content/70 tabular-nums">{{ $rangeValue }}%</span>
		</div>
		<input type="range" min="{{ $min }}" max="{{ $max }}" step="5" wire:model.live.debounce.100ms="rangeValue"
				class="range range-primary range-xs">
</div>

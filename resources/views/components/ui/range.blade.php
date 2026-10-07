<?php

declare(strict_types=1);

use Livewire\Component;

new class extends Component {
  public string $title;
  public int $rangeNumber;
};
?>

<div>
		<div class="mb-1 flex justify-between text-sm">
				<span class="font-semibold capitalize">{{ $title }}</span>
				<span class="text-base-content/70 tabular-nums">{{ $rangeNumber }}%</span>
		</div>
		<input type="range" min="10" max="100" step="5" wire:model.live.debounce.100ms="rangeNumber"
				class="range range-primary range-xs">
</div>

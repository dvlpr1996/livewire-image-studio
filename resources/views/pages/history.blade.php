<?php

declare(strict_types=1);

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('history')] class extends Component {};
?>

<div>
		<x-coming-soon title="History"
				description="Batch history is on its way. Soon you'll see every optimization you've run and be able to re-download past ZIPs."
				icon="o-clock" />
</div>

@props([
    'label' => '',
    'link' => '#',
])

<x-button label="{{ $label }}" link="{{ route($link) }}"
		class="btn-sm {{ request()->routeIs($link) ? 'btn-neutral' : 'btn-ghost' }} rounded-full text-sm font-medium capitalize"
		responsive />

<?php

use Livewire\Volt\Component;

new class extends Component {
    public function with() : array
    {
        return [
            'kids' => Auth::user()
                ->kids()
                ->orderBy('name', 'asc')
                ->get()
        ];
    }


}; ?>

<div>
    <table class="min-w-full text-left text-sm font-light text-surface dark:text-white">
        <thead class="border-b border-t border-neutral-200 font-medium dark:border-white/10 bg-cyan-700 text-white">
            <tr>
                <th width="100" class="px-6 py-4">ID</th>
                <th class="px-6 py-4">Name</th>
                <th width="250" class="px-6 py-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kids as $kidIndex => $kid)
                @if($kidIndex % 2 > 0)
                    <tr class="border-b border-neutral-200 bg-slate-50 dark:border-white/10 hover:bg-slate-100">
                @else
                    <tr class="border-b border-neutral-200 bg-white dark:border-white/10 dark:bg-body-dark hover:bg-slate-100">
                @endif
                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $kid->id }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $kid->name }}</td>
                    <td class="whitespace-nowrap px-6 py-4 text-right">
                        <x-red-button type="button">
                            <img src="{{ asset('/icons/x-circle.svg') }}" class="mr-1 h-5 w-5" alt="Delete">
                            Delete
                        </x-red-button>

                        <x-primary-button href="{{ route('kids.edit', $kid->id) }}" type="button" wire:navigate>
                            <img src="{{ asset('/icons/x-circle.svg') }}" class="mr-1 h-5 w-5" alt="Edit">
                            Edit
                        </x-primary-button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

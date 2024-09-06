<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="mb-4">
                    <x-alert-default>
                        {{ session('message') }}
                    </x-alert-default>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <h2 class="p-6 text-lg font-medium text-gray-900 dark:text-gray-100">
                    Summary
                </h2>

                <div class="grid grid-cols-2 gap-4">
                    <h2 class="p-6 text-lg font-medium text-gray-900 dark:text-gray-100">
                        Trips
                    </h2>

                    <div class="p-6 text-gray-900 dark:text-gray-100 text-right">
                        <x-primary-button href="{{ route('trips.create') }}" type="button" wire:navigate>
                            <img src="{{ asset('/icons/document-plus.svg') }}" class="mr-1 h-5 w-5" alt="Add Trip">
                            Add Trip
                        </x-primary-button>
                    </div>
                </div>

                <table class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                    <thead class="border-b border-t border-neutral-200 font-medium dark:border-white/10 bg-cyan-700 text-white">
                        <tr>
                            <th width="100" class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">When</th>
                            <th class="px-6 py-4">Where</th>
                            <th class="px-6 py-4">Who</th>
                            <th width="250" class="px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trips as $tripIndex => $trip)
                            @if($tripIndex % 2 > 0)
                                <tr class="border-b border-neutral-200 bg-slate-50 dark:border-white/10 hover:bg-slate-100">
                            @else
                                <tr class="border-b border-neutral-200 bg-white dark:border-white/10 dark:bg-body-dark hover:bg-slate-100">
                            @endif
                                <td class="whitespace-nowrap px-6 py-4 font-medium">{{$trip->id}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$trip->when}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$trip->where}}</td>
                                <td>
                                    @foreach($trip->kids as $kid)
                                        <livewire:pill :key="$kid->id" :id="$kid->id" :name="$kid->name" :remove="false" />
                                    @endforeach
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
            
                                    <x-red-button type="button" wire:click="delete('{{ $trip->id }}')" wire:confirm="Are you sure you want to delete this trip?">
                                        <img src="{{ asset('/icons/x-circle.svg') }}" class="mr-1 h-5 w-5" alt="Delete">
                                        Delete
                                    </x-red-button>
            
                                    <x-primary-button href="{{ route('trip.edit', $trip->id) }}" type="button" wire:navigate>
                                        <img src="{{ asset('/icons/x-circle.svg') }}" class="mr-1 h-5 w-5" alt="Edit">
                                        Edit
                                    </x-primary-button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

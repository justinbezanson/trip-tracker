<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-gray-200 leading-tight">
            {{ __('Kids') }}
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
                <div class="pt-6 px-6 text-gray-900 dark:text-gray-100 text-right">
                    <x-primary-button href="{{ route('kids.create') }}" type="button" wire:navigate>
                        <img src="{{ asset('/icons/document-plus.svg') }}" class="mr-1 h-5 w-5" alt="Add Kid">
                        Add Kid
                    </x-primary-button>
                </div>

                <div class="pt-6 text-gray-900 dark:text-gray-100">
                    <livewire:kids.show-kids />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

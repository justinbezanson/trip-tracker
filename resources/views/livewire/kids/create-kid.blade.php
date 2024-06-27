<?php

use Livewire\Volt\Component;
use App\Models\Kid;

new class extends Component {
    public string $name = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = '';
    }

    public function createKid(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        Auth::user()->kids()->create($validated);

        session()->flash('message', 'Kid was created.');
        redirect()->route('kids.index');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Kid Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Create a new kid.") }}
        </p>
    </header>

    <form wire:submit="createKid" class="mt-6 space-y-6">
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="kid-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>

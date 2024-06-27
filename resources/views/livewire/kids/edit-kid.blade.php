<?php

use Livewire\Volt\Component;
use App\Models\Kid;

new class extends Component {
    public ?Kid $kid = null;
    public string $name = '';

    /**
     * Mount the component.
     */
    public function mount(Kid $kid): void
    {
        $this->kid = $kid;
        $this->name = $kid->name;
    }

    public function updateKid(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $this->kid->fill($validated);

        $this->kid->save();

        Session::flash('message', 'Kid was updated.');
        $this->dispatch('kid-updated', name: $this->kid->name);
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Kid Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your kid's information.") }}
        </p>
    </header>

    <form wire:submit="updateKid" class="mt-6 space-y-6">
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

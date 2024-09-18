<?php

use App\Models\Kid;
use App\Models\Trip;
use Livewire\Volt\Component;

new class extends Component {
    public Trip $trip;

    public function mount(Trip $trip): void
    {
        $this->trip = $trip;
    }

    public function deleteTrip(): void
    {
        $this->trip->kids()->detach();
        $this->trip->delete();

        session()->flash('message', 'Trip was deleted.');
        redirect()->route('dashboard');
    }
}; ?>

<x-red-button type="button" wire:click="deleteTrip" wire:confirm="Are you sure you want to delete this trip?">
    <img src="{{ asset('/icons/x-circle.svg') }}" class="mr-1 h-5 w-5" alt="Delete">
    Delete  
</x-red-button>


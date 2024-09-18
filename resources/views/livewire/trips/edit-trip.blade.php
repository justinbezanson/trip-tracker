<?php 

use Livewire\Volt\Component;
use App\Models\Kid;
use App\Models\Trip;
use Illuminate\Support\Collection;

new class extends Component {
    public Trip $trip;
    public string $date = '';
    public string $where = '';
    public string $who = '';
    public Collection $kids;
    public array $selectedKids = [];
    public Collection $whereResults;

    protected $listeners = ['tagRemoved' => 'tagRemoved'];

    /**
     * Mount the component.
     */
    public function mount(Trip $trip): void
    {
        $this->trip = $trip;
        $this->date = $trip->when;
        $this->where = $trip->where;
        $this->who = '';

        foreach($trip->kids as $kid) {
            $this->selectedKids[] = $kid->id;
        }

        $this->whereResults = new Collection();

        $this->kids = Kid::all()->pluck('name', 'id');

        $this->whereResults = Trip::groupBy('where')->pluck('where');
    }

    public function updateTrip(): void
    {        
        $validated = $this->validate([
            'date' => ['required', 'date:Y-m-d'],
            'where' => ['required', 'string', 'max:255'],
        ]);

        if(empty($this->selectedKids)) {
            $this->addError('who', __('Please select at least one kid.'));
        }

        $this->trip->when = $this->date;
        $this->trip->where = $this->where;
        $this->trip->user_id = Auth::user()->id;
        $this->trip->save();

        $this->trip->kids()->detach();
        foreach($this->selectedKids as $kid) {
            $this->trip->kids()->attach($kid);
        }

        session()->flash('message', 'Trip was updated.');
        redirect()->route('dashboard');
    }

    public function addKid()
    {
        if(!empty($this->who) && !in_array($this->who, $this->selectedKids)) {
            $this->selectedKids[] = $this->who;
        }

        $this->who = '';
    }

    public function tagRemoved(string $id)
    {
        $this->selectedKids = array_diff($this->selectedKids, [$id]);
    }

}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Trip Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Edit trip.") }}
        </p>
    </header>

    <form wire:submit="updateTrip" class="mt-6 space-y-6">
        <div>
            <x-input-label for="date" :value="__('Date')" />
            <x-text-input wire:model="date" id="date" name="date" type="date" class="mt-1 block w-full" autofocus autocomplete="date" />
            <x-input-error class="mt-2" :messages="$errors->get('date')" />
        </div>

        <div>
            <x-input-label for="where" :value="__('Where Are We Going?')" />
            <x-text-input 
                wire:model="where" 
                id="where" name="where" 
                type="text" class="mt-1 block w-full" 
                autocomplete="off"
                list="whereOptions"
            />

            <datalist id="whereOptions">
                @foreach($whereResults as $result)
                    <option
                        wire:key="{{ $result }}"
                        data-value="{{ $result }}"
                        value="{{ $result }}"
                    ></option>
                @endforeach
            </datalist>
            
            <x-input-error class="mt-2" :messages="$errors->get('where')" />
        </div>

        <div>
            <x-input-label for="who" :value="__('Who Is Going?')" />
            <select 
                wire:model="who" 
                id="who" 
                name="who" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                wire:change="addKid()"
            >
                <option value="">{{ __('Select a kid...') }}</option>
                @foreach($kids as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('who')" />

            @if (count($selectedKids) > 0)
            <div class="mt-2">
                <span class="text-sm">{{ __('Added') }}:</span>

                @foreach($selectedKids as $kid)
                    <livewire:pill :key="$kid" :id="$kid" :name="$kids[$kid]" />
                @endforeach
            </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="trip-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
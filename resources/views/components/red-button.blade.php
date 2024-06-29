<x-primary-button  {{ $attributes->merge(['type' => 'button', 'class' => 'bg-red-700 hover:bg-red-800']) }}>
    {{ $slot }}
</x-primary-button>
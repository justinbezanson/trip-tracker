<div {{ $attributes->merge(['class' => 'alert-default border-l-4 border-blue-400 bg-blue-50 p-4']) }} onclick="this.remove()">
    {{ $slot }}
    <div class="text-xs italic text-gray-300">
        Click to dismiss
    </div>
</div>
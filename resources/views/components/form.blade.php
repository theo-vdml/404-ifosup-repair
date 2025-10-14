@props([
    'class' => '',
])

<form {{ $attributes->merge(['class' => "grid grid-cols-1 lg:grid-cols-2 gap-4 $class"]) }}>
    {{ $slot }}

    @isset($actions)
        <div class="flex justify-end mt-4 space-x-2 lg:col-span-2">
            {{ $actions }}
        </div>
    @endisset
</form>

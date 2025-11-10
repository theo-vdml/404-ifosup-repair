@props([
    'multipart' => false,
    'method' => 'POST',
    'csrf' => true,
])

<form {{ $attributes->withoutTwMergeClasses()->twMerge('grid grid-cols-1 lg:grid-cols-2 gap-4') }}
    enctype="{{ $multipart ? 'multipart/form-data' : 'application/x-www-form-urlencoded' }}"
    method="{{ strtoupper($method) === 'GET' ? 'GET' : 'POST' }}">

    {{-- CSRF Token --}}
    @if ($csrf)
        @csrf
    @endif

    {{-- Spoof HTTP Method if not GET or POST --}}
    @if (!in_array(strtoupper($method), ['GET', 'POST']))
        @method($method)
    @endif

    {{-- Form Body (default slot) --}}
    {{ $slot }}

    {{-- Form Actions (named slot) --}}
    @isset($actions)
        <div {{ $attributes->twMergeFor('actions', 'flex justify-end mt-4 space-x-2 lg:col-span-2') }}>
            {{ $actions }}
        </div>
    @endisset
</form>

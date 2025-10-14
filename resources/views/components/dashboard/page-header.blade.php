@props([
    'title' => 'Dashboard Page',
    'description' => 'Welcome back! Here\'s an overview of your activity.',
    'actions' => null,
])

<div class="flex flex-col gap-4 pb-8 mb-8 border-b border-slate-300/50 md:flex-row md:items-start md:justify-between">
    <div>
        <h1 class="text-3xl font-bold text-slate-900">{{ $title }}</h1>
        <p class="mt-2 text-slate-600">{{ $description }}</p>
    </div>

    @if ($actions)
        <div class="mt-4">
            {{ $actions }}
        </div>
    @endif
</div>

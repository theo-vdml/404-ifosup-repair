@props([
    'title' => 'Dashboard Page',
    'description' => 'Welcome back! Here\'s an overview of your activity.',
])

<div class="pb-8 mb-8 border-b border-slate-300/50">
    <h1 class="text-3xl font-bold text-slate-900">{{ $title }}</h1>
    <p class="mt-2 text-slate-600">{{ $description }}</p>
</div>

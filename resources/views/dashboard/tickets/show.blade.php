<x-dashboard-layout>
    <div
        class="flex flex-col gap-4 pb-8 mb-8 border-b border-slate-300/50 md:flex-row md:items-start md:justify-between">

        <div>
            <h1 class="text-4xl font-medium text-slate-900">{{ $ticket->title }} <span
                    class="text-slate-500 font-normal">#{{ $ticket->id }}</span></h1>
            <p class="mt-2 text-slate-600">{{ $ticket->description }}</p>
        </div>

        <div>
            <span
                class="text-amber-500 bg-amber-500/20 border border-amber-500 rounded-full p-2 px-4 flex gap-2 items-center text-sm whitespace-nowrap">
                <x-heroicon-o-clock class="w-4 h-4" />
                En cours
            </span>
        </div>
    </div>


    <div class="grid grid-cols-4">

        <div class="col-span-3 h-64 bg-red-200"></div>
        <div class="col-span-1 h-64 bg-green-200"></div>

    </div>

</x-dashboard-layout>

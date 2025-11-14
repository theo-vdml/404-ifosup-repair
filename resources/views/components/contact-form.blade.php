<form action="{{ route('contact.submit') }}" method="POST" class="space-y-4 bg-white rounded-lg p-6 shadow">
    @csrf
    
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-700">Nom</label>
            <input 
                name="name" 
                type="text"
                value="{{ old('name') }}"
                class="mt-1 block w-full border rounded-md p-2 @error('name') border-red-500 @else border-gray-200 @enderror" 
            />
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-gray-700">Prénom</label>
            <input 
                name="surname" 
                type="text"
                value="{{ old('surname') }}"
                class="mt-1 block w-full border rounded-md p-2 @error('surname') border-red-500 @else border-gray-200 @enderror" 
            />
            @error('surname')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
    
    <div>
        <label class="block text-gray-700">Email</label>
        <input 
            name="email" 
            type="email" 
            value="{{ old('email') }}"
            class="mt-1 block w-full border rounded-md p-2 @error('email') border-red-500 @else border-gray-200 @enderror" 
        />
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
    
    <div>
        <label class="block text-gray-700">Message / appareil</label>
        <textarea 
            name="message" 
            rows="4" 
            class="mt-1 block w-full border rounded-md p-2 @error('message') border-red-500 @else border-gray-200 @enderror"
        >{{ old('message') }}</textarea>
        @error('message')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
    
    <div class="flex items-center justify-between">
        <button type="submit" class="btn-green">Envoyer</button>
        <div class="text-gray-500">Réponse en général sous 24h.</div>
    </div>
</form>

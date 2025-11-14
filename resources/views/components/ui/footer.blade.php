

<footer class="bg-black text-[#8a8a8a] pt-8 pb-4 relative">
    <div class="w-full px-4">
    <ul class="flex flex-col gap-2 text-sm text-[#8a8a8a] w-full max-w-xs py-12 p-0 md:pt-0">
            <li><a href="{{ route('contact') }}" class="hover:underline transition">Contactez-nous</a></li>
            <li><a href="{{ route('about') }}" class="hover:underline transition">À propos de nous</a></li>
            <li><a href="{{ route('login') }}" class="hover:underline transition">Connexion</a></li>
            <li><a href="{{ route('register') }}" class="hover:underline transition">Inscription</a></li>
        </ul>
        <div class="w-full flex justify-start items-end mt-8">
            <img src="/branding/404logo-gray.svg" alt="404 Logo Gray" class="h-10 select-none pointer-events-none opacity-30" draggable="false">
        </div>
        <div class="w-full flex justify-center text-xs py-8 pb-2">
            <span class="text-[#8a8a8a]">&copy; Atelier 404, {{ date('Y') }}. All rights reserved.</span>
        </div>
    </div>
</footer>

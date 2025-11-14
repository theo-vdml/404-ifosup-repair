<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atelier 404</title>
    @include('components.fonts')
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/frontend.css'])
</head>
<body>
@include('components.ui.header')
@if(session('success'))
    <div class="mt-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
        {{ session('success') }}
    </div>
@endif
<main>
    <div class="h-screen static">
        <div class="block bottom-0 left-0 w-full p-3 absolute">
            <div class="grid">
                <img class="w-2/3 pb-2 justify-self-end opacity-40" src="{{ asset('branding/tagline.svg') }}">
            </div>
            <img class="w-100" src="{{ asset('branding/404logo-green.svg') }}">
        </div>
    </div>

    <section class="bg-gradient-to-b from-white to-gray-100 overflow-hidden">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 h-screen">
            <div class="md:pt-32 pt-32 p-4 md:p-0 h-auto">
                <h2 class="text-4xl md:text-6xl tracking-tight">Appareils cassés ? Venez à l'atelier!</h2>
                <p class="mt-8 text-lg text-gray-700">Diagnostic rapide, réparations sur place et conseils avisés.</p>
                <a href="{{ route('contact') }}" class="mt-6 btn-green">Prendre rendez-vous</a>
            </div>
            <div class="flex items-center justify-center pt-12 md:pt-0">
                <img src="{{ asset('images/phone-cracked.png') }}" class="max-w-md" alt="cracked phone">
            </div>
        </div>
    </section>

    <section class="max-w-7xl py-32 md:py-12 mx-auto">
        <h3 class="text-4xl md:text-5xl mb-12 text-center">Comment fonctionne l'atelier&nbsp;404&nbsp;?</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-24">
            <div class="flex flex-col items-center md:py-0">
                <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mb-6">
                    <span class="text-4xl">📦</span>
                </div>
                <div class="text-left text-md text-gray-700 w-full max-w-md block">
                    Apportez votre appareil cassé ou en panne à l'atelier.
                </div>
            </div>
            <div class="flex flex-col items-center py-12 md:py-0">
                <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mb-6">
                    <span class="text-4xl">🔍</span>
                </div>
                <div class="text-left text-md text-gray-700 w-full max-w-md block">
                    Diagnostic gratuit par nos étudiants et encadrants, puis explication et devis (seules les pièces sont à votre charge).
                </div>
            </div>
            <div class="flex flex-col items-center py-12 md:py-0">
                <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mb-6">
                    <span class="text-4xl">🔧</span>
                </div>
                <div class="text-left text-md text-gray-700 w-full max-w-md block">
                    Réparation sur place ou à récupérer plus tard. Vous aidez à former les réparateurs de demain.
                </div>
            </div>
        </div>
    </section>

    <hr class="border-gray-300 my-12 w-full">

    <section class="max-w-7xl mx-auto py-12 px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                <h2 class="text-4xl md:text-6xl tracking-tight mb-4">Contactez-nous</h2>
                <p class="mt-2 text-gray-600">Remplissez le formulaire pour toute question ou demande de rendez-vous.</p>
            </div>
            <div>
                @include('components.contact-form')
            </div>
        </div>
    </section>
</main>
@include('components.ui.footer')
</body>
</html>

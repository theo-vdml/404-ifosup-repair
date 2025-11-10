<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atelier 404</title>
    @include('components.fonts')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .top-tagline{width:66%;opacity:.4}
    </style>
</head>
<body>
<main>
    <header class="sticky z-10">
        @include('components.ui.header')
    </header>
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
            <div class="md:py-32 p-4 md:p-0">
                <h2 class="text-4xl md:text-6xl tracking-tight">Appareils cassés ? Venez à l'atelier!</h2>
                <p class="mt-4 text-lg text-gray-700">Diagnostic rapide, réparations sur place et conseils avisés.<br>Déposez votre appareil ou prenez rendez-vous.</p>
                <a href="{{ route('contact') }}" class="mt-6 btn-green">Prendre rendez-vous</a>
            </div>
            <div class="flex items-center justify-center">
                <img src="{{ asset('images/phone-cracked.png') }}" class="max-w-md" alt="cracked phone">
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                <h3>Notre fonctionnement</h3>
                <p class="mt-2 text-gray-600">Apportez votre appareil, nous effectuerons un diagnostic et vous proposerons une réparation sans frais (à l'exception des pièces). En nous faisant confiance, vous contribuez à former les réparateurs de demain.</p>
            </div>
            <div>
                <form id="contact" action="{{ url('/contact') }}" method="POST" class="space-y-4 bg-white rounded-lg p-6 shadow">
                    @csrf
                    <div grid class="grid grid-cols-2 gap-4">
                        <div><label class="block text-gray-700">Nom</label><input name="name" required class="mt-1 block w-full border border-gray-200 rounded-md p-2" /></div>
                        <div><label class="block text-gray-700">Prénom</label><input name="surname" required class="mt-1 block w-full border border-gray-200 rounded-md p-2" /></div>
                    </div>
                    <div><label class="block text-gray-700">Email</label><input name="email" type="email" required class="mt-1 block w-full border border-gray-200 rounded-md p-2" /></div>
                    <div><label class="block text-gray-700">Message / appareil</label><textarea name="message" rows="4" required class="mt-1 block w-full border border-gray-200 rounded-md p-2"></textarea></div>
                    <div class="flex items-center justify-between"><button type="submit" class="btn-green">Envoyer</button><div class="text-gray-500">Réponse en général sous 24h.</div></div>
                </form>
            </div>
        </div>
    </section>
</main>
<footer>@include('components.ui.footer')</footer>
</body>
</html>

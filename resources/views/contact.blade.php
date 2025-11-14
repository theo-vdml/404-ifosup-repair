<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Atelier 404</title>
    @include('components.fonts')
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/frontend.css'])
</head>
<body>
@include('components.ui.header')
<main>
    <section class="max-w-7xl mx-auto px-6 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                <h2 class="text-4xl md:text-6xl tracking-tight mb-4">Contactez-nous</h2>
                <p class="mt-2 text-lg text-gray-700">Remplissez le formulaire pour toute question ou demande de rendez-vous.</p>

                @if(session('success'))
                    <div class="mt-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif
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

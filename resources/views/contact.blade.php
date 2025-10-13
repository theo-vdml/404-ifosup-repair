<x-guest-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="space-y-2 text-center">
            <h1 class="text-2xl font-semibold text-gray-900">Contact Us</h1>
            <p class="text-sm text-gray-600">We'd love to hear from you</p>
        </div>

        <!-- Contact Form -->
        <form class="space-y-4" method="POST" action="#"
            onsubmit="event.preventDefault(); alert('Contact form submitted! (This is a demo)');">
            @csrf
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="block w-full mt-1" required
                    autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="block w-full mt-1" required />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="subject" :value="__('Subject')" />
                <x-text-input id="subject" name="subject" type="text" class="block w-full mt-1" required />
                <x-input-error class="mt-2" :messages="$errors->get('subject')" />
            </div>

            <div>
                <x-input-label for="message" :value="__('Message')" />
                <textarea id="message" name="message" rows="4"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required placeholder="Tell us how we can help you..."></textarea>
                <x-input-error class="mt-2" :messages="$errors->get('message')" />
            </div>

            <div class="flex items-center justify-between pt-2">
                <x-primary-button>
                    {{ __('Send Message') }}
                </x-primary-button>
            </div>
        </form>

        <!-- Contact Information -->
        <div class="pt-6 border-t border-gray-200">
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900">Other Ways to Reach Us</h3>

                <div class="grid grid-cols-1 gap-4 text-sm">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-8 h-8 bg-indigo-100 rounded-full">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Email</p>
                            <p class="text-gray-600">hello@example.com</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-8 h-8 bg-indigo-100 rounded-full">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Phone</p>
                            <p class="text-gray-600">+1 (555) 123-4567</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-8 h-8 bg-indigo-100 rounded-full">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Address</p>
                            <p class="text-gray-600">123 Business St, City, State 12345</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Links -->
        <div class="pt-4 border-t border-gray-200">
            <div class="flex justify-center space-x-4 text-sm">
                <a href="{{ route('about') }}" class="text-indigo-600 transition-colors hover:text-indigo-500">
                    About Us
                </a>
                <span class="text-gray-300">•</span>
                <a href="/" class="text-gray-500 transition-colors hover:text-gray-700">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>

<x-guest-layout>
    <div class="text-center space-y-6">
        <!-- Header -->
        <div class="space-y-2">
            <h1 class="text-2xl font-semibold text-gray-900">About Us</h1>
            <p class="text-gray-600 text-sm">Learn more about our mission and values</p>
        </div>

        <!-- Content -->
        <div class="space-y-4 text-left">
            <div class="space-y-3">
                <h2 class="text-lg font-medium text-gray-900">Our Story</h2>
                <p class="text-gray-700 text-sm leading-relaxed">
                    We are passionate about creating innovative solutions that make a difference in people's lives.
                    Our journey started with a simple idea: to build technology that serves humanity and brings
                    communities together.
                </p>
            </div>

            <div class="space-y-3">
                <h2 class="text-lg font-medium text-gray-900">Our Mission</h2>
                <p class="text-gray-700 text-sm leading-relaxed">
                    To deliver exceptional digital experiences that empower individuals and organizations to achieve
                    their goals through cutting-edge technology and thoughtful design.
                </p>
            </div>

            <div class="space-y-3">
                <h2 class="text-lg font-medium text-gray-900">Our Values</h2>
                <ul class="text-gray-700 text-sm space-y-2">
                    <li class="flex items-start">
                        <span class="w-2 h-2 bg-indigo-500 rounded-full mt-1.5 mr-3 flex-shrink-0"></span>
                        <span><strong>Innovation:</strong> We continuously push boundaries to create better
                            solutions</span>
                    </li>
                    <li class="flex items-start">
                        <span class="w-2 h-2 bg-indigo-500 rounded-full mt-1.5 mr-3 flex-shrink-0"></span>
                        <span><strong>Quality:</strong> Excellence in everything we do, from code to customer
                            service</span>
                    </li>
                    <li class="flex items-start">
                        <span class="w-2 h-2 bg-indigo-500 rounded-full mt-1.5 mr-3 flex-shrink-0"></span>
                        <span><strong>Community:</strong> Building connections and supporting each other's growth</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Footer Links -->
        <div class="pt-4 border-t border-gray-200">
            <div class="flex justify-center space-x-4 text-sm">
                <a href="{{ route('contact') }}" class="text-indigo-600 hover:text-indigo-500 transition-colors">
                    Contact Us
                </a>
                <span class="text-gray-300">•</span>
                <a href="/" class="text-gray-500 hover:text-gray-700 transition-colors">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>

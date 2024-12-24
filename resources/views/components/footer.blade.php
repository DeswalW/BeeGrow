<footer class="bg-white dark:bg-gray-900 px-4 md:px-10 lg:px-20 border-t border-gray-200 z-10">
    <div class="mx-auto w-full py-6 lg:py-8">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2 md:gap-8">
            <!-- Logo Section -->
            <div class="flex flex-col items-center md:items-start">
                <x-application-logo/>
                <!-- Social Media Icons - Mobile & Tablet -->
                <div class="flex space-x-4 my-4 md:hidden">
                    <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 col-span-1 md:col-span-2">
                <!-- Home Links -->
                <div>
                    <h2 class="mb-2 text-sm font-semibold text-gray-900 uppercase dark:text-white">Home</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium text-sm space-y-2">
                        <li><a href="#" class="hover:underline">Home</a></li>
                        <li><a href="#" class="hover:underline">Explore</a></li>
                        <li><a href="#" class="hover:underline">Portfolio</a></li>
                        <li><a href="#" class="hover:underline">Learn</a></li>
                        <li><a href="#" class="hover:underline">Blog</a></li>
                    </ul>
                </div>

                <!-- Profile Links -->
                <div>
                    <h2 class="mb-2 text-sm font-semibold text-gray-900 uppercase dark:text-white">Profile</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium text-sm space-y-2">
                        <li><a href="#" class="hover:underline">Profile</a></li>
                        <li><a href="#" class="hover:underline">Settings</a></li>
                    </ul>
                </div>

                <!-- Legal Links -->
                <div>
                    <h2 class="mb-2 text-sm font-semibold text-gray-900 uppercase dark:text-white">Legal</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium text-sm space-y-2">
                        <li><a href="#" class="hover:underline">Terms</a></li>
                        <li><a href="#" class="hover:underline">Privacy</a></li>
                    </ul>
                </div>
            </div>

            <!-- Social Media & Copyright - Desktop -->
            <div class="hidden lg:flex flex-col justify-between">
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Copyright - Mobile, Tablet & Desktop -->
        <div class="mt-8 text-center">
            <span class="text-sm text-gray-500 dark:text-gray-400">© {{ date('Y') }} BeeGrow. All rights reserved.</span>
        </div>
    </div>
</footer>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Updated Title to use Blade variable syntax -->
    <title>{{ $title ?? 'OTA Dashboard PT1.0' }}</title>
    
    <!-- Blade directive for Vite asset inclusion (will be processed by your framework) -->
    @vite('resources/css/app.css')
    
    <!-- Load Font Awesome Icons CDN (RE-ADDED: Necessary for icons to render correctly) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Load Inter Font (Keeping for static preview fidelity) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* Custom CSS (assuming Tailwind classes are available) */
        body { font-family: 'Inter', sans-serif; }
        /* Prevent layout shifts during transitions */
        .sidebar-transition {
            transition: width 300ms ease-in-out, margin-left 300ms ease-in-out;
        }
        /* Hide element until Alpine is ready (prevents flash of unstyled content) */
        [x-cloak] { display: none; }
    </style>
</head>
<body class="bg-gray-50 antialiased min-h-screen">

<div x-data="dashboardLayout()" class="flex h-screen overflow-hidden">

    <!-- 1. Mobile Backdrop Overlay -->
    <div x-show="isMobileMenuOpen" x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="isMobileMenuOpen = false"
         class="fixed inset-0 z-40 bg-gray-900/40 lg:hidden" x-cloak>
    </div>

    <!-- 2. Sidebar Component -->
    <aside :class="{'w-64': !isCollapsed, 'w-20': isCollapsed}"
           x-show="isMobileMenuOpen || window.innerWidth >= 1024"
           @keydown.escape.window="isMobileMenuOpen = false"
           class="fixed inset-y-0 left-0 z-50 flex-shrink-0 bg-white border-r border-gray-200 shadow-xl sidebar-transition flex flex-col h-full lg:static lg:block"
           x-cloak>

        <!-- Sidebar Header / Logo -->
        <div class="flex items-center px-6 py-4 border-b border-gray-100 h-16">
            <a href="#" class="flex items-center overflow-hidden">
                <i class="fa-solid fa-cloud-arrow-up text-2xl text-indigo-600 mr-2"></i>
                <span x-show="!isCollapsed" class="text-xl font-extrabold text-gray-800 tracking-tight transition-opacity duration-300">OTA PT1.0</span>
            </a>
        </div>

        <!-- Navigation Links -->
<nav class="flex-1 overflow-y-auto px-4 py-4 space-y-2">

    {{-- Home --}}
    <a wire:navigate href="/home"
       @class([
           'flex items-center rounded-xl px-3 py-3 transition-all duration-150 ease-in-out group',
           'bg-indigo-50 text-indigo-700 font-semibold shadow-sm' => request()->is('home'),
           'text-gray-600 hover:bg-gray-50 hover:text-gray-800' => !request()->is('home')
       ])>
        <i class="fa-solid fa-house text-xl w-6 transition-colors duration-150 group-hover:text-indigo-600"></i>
        <span x-show="!isCollapsed" class="ml-4 text-sm whitespace-nowrap transition-opacity duration-300" x-cloak>Home</span>
        <span x-show="isCollapsed" x-cloak role="tooltip" class="absolute left-full ml-4 px-3 py-1 text-xs font-medium text-white bg-gray-800 rounded-lg shadow-md opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-300 z-50">Home</span>
    </a>

    {{-- Post --}}
    <a wire:navigate href="/post"
       @class([
           'flex items-center rounded-xl px-3 py-3 transition-all duration-150 ease-in-out group',
           'bg-indigo-50 text-indigo-700 font-semibold shadow-sm' => request()->is('post*'),
           'text-gray-600 hover:bg-gray-50 hover:text-gray-800' => !request()->is('post*')
       ])>
        <i class="fa-solid fa-file-pen text-xl w-6 transition-colors duration-150 group-hover:text-indigo-600"></i>
        <span x-show="!isCollapsed" class="ml-4 text-sm whitespace-nowrap transition-opacity duration-300" x-cloak>Post</span>
        <span x-show="isCollapsed" x-cloak role="tooltip" class="absolute left-full ml-4 px-3 py-1 text-xs font-medium text-white bg-gray-800 rounded-lg shadow-md opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-300 z-50">Post</span>
    </a>

    {{-- Settings --}}
    <a wire:navigate href="/settings"
       @class([
           'flex items-center rounded-xl px-3 py-3 transition-all duration-150 ease-in-out group',
           'bg-indigo-50 text-indigo-700 font-semibold shadow-sm' => request()->is('settings*'),
           'text-gray-600 hover:bg-gray-50 hover:text-gray-800' => !request()->is('settings*')
       ])>
        <i class="fa-solid fa-gear text-xl w-6 transition-colors duration-150 group-hover:text-indigo-600"></i>
        <span x-show="!isCollapsed" class="ml-4 text-sm whitespace-nowrap transition-opacity duration-300" x-cloak>Settings</span>
        <span x-show="isCollapsed" x-cloak role="tooltip" class="absolute left-full ml-4 px-3 py-1 text-xs font-medium text-white bg-gray-800 rounded-lg shadow-md opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-300 z-50">Settings</span>
    </a>

</nav>


        <!-- Sidebar Footer / Collapse Toggle -->
        <div class="p-4 border-t border-gray-100 flex justify-center lg:justify-end">
            <button @click="isCollapsed = !isCollapsed" class="hidden lg:inline-flex p-2 rounded-full text-gray-500 hover:bg-gray-100 hover:text-indigo-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <i :class="isCollapsed ? 'fa-solid fa-arrow-right' : 'fa-solid fa-arrow-left'" class="text-lg"></i>
            </button>
        </div>
    </aside>

    <!-- 3. Main Content Area (Uses flex-1 and dynamic margins to ensure 100% of remaining width is taken) -->
    <div class="flex-1 flex flex-col overflow-auto sidebar-transition w-full">

        <!-- Topbar Component -->
        <header class="flex-shrink-0 bg-white border-b border-gray-200 shadow-md h-16 sticky top-0 z-30">
            <div class="flex items-center justify-between h-full px-4 sm:px-6">

                <!-- Left: Mobile Toggle & Logo (on mobile) -->
                <div class="flex items-center space-x-3 lg:hidden">
                    <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="text-gray-600 hover:text-indigo-600 focus:outline-none p-1">
                        <i class="fa-solid fa-bars fa-lg"></i>
                    </button>
                    <span class="font-bold text-lg text-indigo-600">OTA PT1.0</span>
                </div>

                <!-- Center: Search Bar -->
                <div class="flex-1 flex justify-center max-w-xl mx-4 hidden md:flex">
                    <div class="w-full relative">
                        <input type="search" placeholder="Search data, documents, or settings..."
                               class="w-full bg-gray-100 border-2 border-gray-200 rounded-full py-2 pl-12 pr-6 text-sm placeholder-gray-500 focus:outline-none focus:ring-3 focus:ring-indigo-100 focus:border-indigo-500 shadow-inner transition duration-150">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                    </div>
                </div>

                <!-- Right: Notifications + Status + Avatar -->
                <div class="flex items-center space-x-4">

                    <!-- Notifications Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false" class="relative text-gray-600 hover:text-indigo-600 p-2 rounded-full hover:bg-gray-100 transition-colors duration-150 focus:outline-none">
                            <i class="fa-solid fa-bell fa-lg"></i>
                            <span class="absolute top-1 right-1 inline-block w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                        </button>
                        <div x-show="open" x-transition.origin.top.right class="absolute right-0 mt-3 w-72 bg-white border border-gray-200 rounded-xl shadow-2xl overflow-hidden z-50">
                            <div class="p-4 font-semibold text-gray-800 border-b">
                                <i class="fa-solid fa-inbox text-indigo-500 mr-2"></i> Recent Alerts (3)
                            </div>
                            <ul class="divide-y divide-gray-100">
                                <li class="p-4 hover:bg-indigo-50 cursor-pointer text-sm">
                                    <p class="font-medium text-gray-800">Critical Error: Deployment failed</p>
                                    <p class="text-xs text-gray-500">2 minutes ago</p>
                                </li>
                                <li class="p-4 hover:bg-indigo-50 cursor-pointer text-sm">
                                    <p class="font-medium text-gray-800">New User: Jane Doe registered</p>
                                    <p class="text-xs text-gray-500">1 hour ago</p>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- System Status (Simple Indicator) -->
                    <div class="hidden sm:flex items-center bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full shadow-sm cursor-pointer hover:bg-green-200 transition">
                         <span class="h-2 w-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                         System Online
                    </div>

                    <!-- User Avatar Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false" class="flex items-center p-0.5 rounded-full ring-2 ring-indigo-300 hover:ring-indigo-500 transition-all focus:outline-none">
                            <img src="https://i.pravatar.cc/40?img=1" alt="User avatar" class="h-9 w-9 rounded-full object-cover">
                        </button>
                        <div x-show="open" x-transition.origin.top.right class="absolute right-0 mt-3 w-48 bg-white border border-gray-200 rounded-xl shadow-2xl overflow-hidden z-50">
                            <div class="px-4 py-3 text-sm border-b">
                                <p class="font-semibold text-gray-800">Jane Doe</p>
                                <p class="text-gray-500">@admin_jane</p>
                            </div>
                            <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 transition-colors flex items-center"><i class="fa-solid fa-user-circle mr-3"></i> Profile</a>
                            <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 transition-colors flex items-center"><i class="fa-solid fa-gear mr-3"></i> Settings</a>
                            <a href="#" class="block px-4 py-3 text-sm text-red-600 hover:bg-red-50 border-t transition-colors flex items-center"><i class="fa-solid fa-sign-out-alt mr-3"></i> Log Out</a>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- Main Content Slot -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-50">
            {{$slot}}
        </main>
    </div>

</div>

<script>
    // This script assumes Alpine.js is already globally available (e.g., loaded by Livewire)
    document.addEventListener('alpine:init', () => {
        Alpine.data('dashboardLayout', () => ({
            // State for mobile view (shows the fixed sidebar overlay)
            isMobileMenuOpen: false,
            // State for desktop view (collapses the sidebar to w-20)
            isCollapsed: false,

            // Initialize the component
            init() {
                // Check screen width on load and set default collapsed state for large screens
                // We default to un-collapsed (64px) for desktop/large screens
                this.isCollapsed = window.innerWidth >= 1024 ? false : true;

                // Watch for window resize to adjust collapsed state dynamically
                window.addEventListener('resize', () => {
                    if (window.innerWidth < 1024) {
                        this.isCollapsed = true; // Collapse on smaller screens to allow full main content
                        this.isMobileMenuOpen = false; // Ensure mobile overlay is closed if we resize down
                    } else {
                        // Re-evaluate if it should be collapsed when resizing up to desktop,
                        // keeping the last state if possible, but ensuring the default is un-collapsed.
                        this.isCollapsed = false; 
                    }
                });
            },
        }))
    });
</script>

</body>
</html>
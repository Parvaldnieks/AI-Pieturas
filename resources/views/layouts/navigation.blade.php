<nav x-data="{ open: false }" class="bg-white dark:bg-black border-b border-orange-500 dark:border-orange-500">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <x-language-switcher />

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ t('dashboard.view.link', 'Sākums') }}
                    </x-nav-link>
                </div>

                @if (auth()->user()->hasPermission('skatit_pieturas'))
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('pieturas.index')" :active="request()->routeIs('pieturas.index')">
                            {{ t('pieturas.index.view.link', 'Pieturas') }}
                        </x-nav-link>
                    </div>
                @endif

                @if (auth()->user()->hasPermission('izveidot_pieturas'))
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('vestures.index')" :active="request()->routeIs('vestures.index')">
                            {{ t('vestures.index.view.link', 'Vēsture') }}
                        </x-nav-link>
                    </div>
                @endif

                @if (auth()->user()->hasPermission('skatit_pieturas'))
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('mp3.index')" :active="request()->routeIs('mp3.index')">
                            {{ t('mp3.index.view.link', 'MP3') }}
                        </x-nav-link>
                    </div>
                @endif

                @if (auth()->check() && auth()->user()->admin)
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                            {{ t('users.index.view.link', 'Lietotāji') }}
                        </x-nav-link>
                    </div>
                @endif

                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('valodas.index')" :active="request()->routeIs('valodas.index')">
                            {{ t('valodas.index.view.link', 'Valodas') }}
                        </x-nav-link>
                    </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <button
                        id="theme-toggle"
                        class="mr-2 p-2 rounded-full border border-orange-500 transition ease-in-out duration-150 active:scale-[0.95]"
                        title="Toggle dark mode"
                        >
                        <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden dark:text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m8.66-8.66h1M3 12H2m15.36 6.36l.7.7M6.34 6.34l-.7-.7m12.02 0l.7-.7M6.34 17.66l-.7.7M12 8a4 4 0 100 8 4 4 0 000-8z" />
                        </svg>

                        <svg id="theme-toggle-dark-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" />
                        </svg>
                    </button>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md dark:text-white bg-white dark:bg-black hover:underline hover:decoration-orange-500 hover:underline-offset-4 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ t('profile.link', 'Profils') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ t('logout.link', 'Iziet') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-black dark:text-white hover:border hover:border-orange-500 dark:hover:text-white hover:bg-white dark:hover:bg-black dark:hover:border dark:hover:border-orange-500 focus:outline-none focus:bg-white dark:focus:bg-black dark:focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ t('dashboard.view.link', 'Sākums') }}
            </x-responsive-nav-link>

            @if (auth()->user()->hasPermission('izveidot_pieturas'))
                <x-responsive-nav-link :href="route('pieturas.index')" :active="request()->routeIs('pieturas')">
                    {{ t('pieturas.index.view.link', 'Pieturas') }}
                </x-responsive-nav-link>
            @endif

            @if (auth()->user()->hasPermission('izveidot_pieturas'))
                <x-responsive-nav-link :href="route('vestures.index')" :active="request()->routeIs('vestures')">
                    {{ t('vestures.index.view.link', 'Vēsture') }}
                </x-responsive-nav-link>
            @endif

            @if (auth()->user()->hasPermission('izveidot_pieturas'))
                <x-responsive-nav-link :href="route('mp3.index')" :active="request()->routeIs('mp3')">
                    {{ t('mp3.index.view.link', 'MP3') }}
                </x-responsive-nav-link>
            @endif

            @if (auth()->check() && auth()->user()->admin)
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users')">
                    {{ t('users.index.view.link', 'Lietotāji') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ t('profile.link', 'Profils') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ t('logout.link', 'Iziet') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

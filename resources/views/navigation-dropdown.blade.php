<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Navigation Links -->
                <div class="hidden sm:flex">
                    <x-jet-nav-link href="{{ route('wallets') }}" :active="request()->routeIs('wallets')">
                        {{ __('Wallets') }}
                    </x-jet-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-jet-nav-link align="right" width="48">
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button class="rounded-full border border-gray-800 w-32 h-12 bg-blue-300" type="submit">Log
                            out
                        </button>
                    </form>
                </x-jet-nav-link>
            </div>
        </div>
    </div>
</nav>

<x-app-layout>
    <div class="flex justify-center">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="flex justify-center text-4xl font-bold">Wallets</div>
            @foreach ($wallets as $wallet)
                <a href="/wallets/{{ $wallet->id }}" dusk="showWallet">
                    <div class="flex w-full h-16 border-gray-800 border items-center mt-4">
                        <div dusk="wallet" class="flex w-3/4 text-xl font-black font-bold truncate">{{ $wallet->name }}</div>
                        <div class="flex w-4/12">€{{ $wallet->getFormattedBalance() }}</div>
                    </div>
                </a>

            @endforeach
            <div class="flex justify-center">
                <form method="get" action="{{ route('createWallet') }}">
                    <button class="mt-12 w-32 h-12 bg-blue-300 rounded-full text-sm border border-gray-800" type="submit">Create new wallet</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


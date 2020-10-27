<x-app-layout>
    <div class="flex justify-center">
        <div class="w-full sm:max-w-md mt-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg absolute">
            <div class="flex justify-center text-4xl font-bold truncate">{{ $wallet->name }}</div>
            <div class="wallet-info container">
                <div class="mr-full mt-2 w-full">Wallet name: <strong>{{ $wallet->name }}</strong></div>
                <div class="mr-full w-full">Balance: <strong>€{{ $wallet->balance }}</strong></div>
            </div>
            <div class="flex space-x-4 w-full mt-6 justify-between">
                <form method="GET" action="/wallets/{{ $wallet->id }}/edit">
                    <button class="rounded-full w-24 h-8 bg-blue-300 border border-gray-800" type="submit">Edit</button>
                </form>
                <form method="GET" action="/wallets/{{ $wallet->id }}/send">
                    <button class="rounded-full w-48 h-8 bg-blue-300 border border-gray-800" type="submit">New Transaction</button>
                </form>
                <form method="POST" action="/wallets/{{ $wallet->id }}">
                    @csrf
                    @method('DELETE')
                    <button class="rounded-full w-24 h-8 bg-blue-300 border border-gray-800" type="submit">Delete</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

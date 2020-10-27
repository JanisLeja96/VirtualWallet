<x-app-layout>
    <div class="flex justify-center">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="flex justify-center text-4xl font-bold">Wallets</div>
            @foreach ($wallets as $wallet)
                <a href="/wallets/{{ $wallet->id }}">
                    <div class="flex w-full h-16 border-gray-800 border items-center mt-4">
                        <div class="flex w-3/4 text-xl font-black font-bold truncate">{{ $wallet->name }}</div>
                        <div class="flex w-4/12">€{{ $wallet->balance }}</div>
                    </div>
                </a>

            @endforeach
            <div class="flex justify-center mr-2 mb-2 ml-auto">
                <form method="get" action="/wallets/create">
                    <button class="mt-12 w-32 h-12 bg-blue-300 items-end rounded-full text-sm" type="submit">Create new wallet</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


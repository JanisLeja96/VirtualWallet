<x-app-layout>
    <div class="flex justify-center">
        <div class="w-2/4 mt-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg absolute">
            <div class="flex justify-center text-4xl font-bold truncate">{{ $wallet->name }}</div>
            <div class="wallet-info container">
                <div class="mr-full mt-2 w-full">Wallet name: <strong>{{ $wallet->name }}</strong></div>
                <div class="mr-full w-full">Wallet ID: <strong>{{ $wallet->id }}</strong></div>
                <div class="mr-full w-full">Balance: <strong>€{{ $wallet->balance }}</strong></div>
            </div>
            <div class="container mt-4">
                @if ($transactions)
                <div class="mr-full w-full font-bold text-xl">Recent transactions</div>
                    <table class="w-full">
                        <tr class="border border-gray-800">
                            <th class="border border-gray-800">Type</th>
                            <th class="border border-gray-800">Amount</th>
                            <th class="border border-gray-800">Description</th>
                            <th class="border border-gray-800">Sender</th>
                            <th class="border border-gray-800">Recipient</th>
                            <th class="border border-gray-800">Time</th>
                            <th class="border border-gray-800">Delete</th>
                        </tr>
                        @foreach ($transactions as $transaction)
                            <tr class="border border-gray-800">
                                <td class="border border-gray-800">{{ $transaction['type'] }}</td>
                                <td class="border border-gray-800">€{{ number_format($transaction['amount'], 2) }}</td>
                                <td class="border border-gray-800">{{ $transaction['description'] }}</td>
                                <td class="border border-gray-800">{{ \App\Models\User::find($transaction['sender_id'])->username }}</td>
                                <td class="border border-gray-800">{{ \App\Models\User::find($transaction['recipient_id'])->username }}</td>
                                <td class="border border-gray-800">{{ \Carbon\Carbon::parse($transaction['created_at'])->format('h:i d/M/Y') }}</td>
                                <td class="border border-gray-800">
                                    <form method="post" action="/wallets/{{ $wallet->id }}/transactions/{{ $transaction['id'] }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="w-full h-full border-gray-800 border bg-red-400" type="submit">X</button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>
            <div class="flex space-x-4 w-full mt-6 justify-between">
                <form method="GET" action="/wallets/{{ $wallet->id }}/edit">
                    <button class="rounded-full w-24 h-8 bg-blue-300 border border-gray-800" type="submit">Rename</button>
                </form>
                <form method="GET" action="/wallets/{{ $wallet->id }}/send">
                    <button class="rounded-full w-48 h-8 bg-blue-300 border border-gray-800" type="submit">New
                        Transaction
                    </button>
                </form>
                <form method="POST" action="/wallets/{{ $wallet->id }}">
                    @csrf
                    @method('DELETE')
                    <button class="rounded-full w-24 h-8 bg-blue-300 border border-gray-800" type="submit">Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

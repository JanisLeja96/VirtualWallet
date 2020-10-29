<x-app-layout>
    <div class="flex justify-center">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="flex justify-center text-4xl font-bold">New Transaction</div>
            <div class="mt-8 flex justify-center">
                <form method="post" action="/wallets/{{ $wallet->id }}/send">
                    @csrf
                    <label for="amount">Amount to send:</label>
                    <input class="flex rounded-full border border-gray-800 @error('amount') is-danger @enderror" name="amount" value="{{ old('amount') }}" required>
                    <p class="help is-danger">{{ $errors->first('name') }}</p>

                    <label for="description">Description:</label>
                    <input class="flex rounded-full border border-gray-800 @error('description') is-danger @enderror" name="description" value="{{ old('description') }}" required>
                    <p class="help is-danger">{{ $errors->first('description') }}</p>

                    <label for="receiver_wallet_id">Recipient's wallet ID:</label>
                    <input class="flex rounded-full border border-gray-800 @error('recipient_wallet_id') is-danger @enderror" name="recipient_wallet_id" value="{{ old('recipient_wallet_id') }}" required>
                    <p class="help is-danger">{{ $errors->first('recipient_wallet_id') }}</p>
                    @if (session('error'))
                        <div class="flex justify-center font-bold text-xl text-red-900">{{ Session::get('error') }}</div>
                    @endif

                    <div class="container flex justify-between">
                        <button type="button" class="mt-6 rounded-full w-24 h-8 bg-blue-300 border border-gray-800" onclick="window.location.href='/wallets/{{ $wallet->id }}'">Back</button>
                        <input type="hidden" name="sender_wallet_id" value="{{ $wallet->id }}">
                        <button dusk="send" class="ml-20 mt-6 rounded-full w-24 h-8 bg-blue-300 border border-gray-800" type="submit">Send</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>

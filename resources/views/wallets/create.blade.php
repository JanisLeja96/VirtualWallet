<x-app-layout>
    <div class="flex justify-center">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="flex justify-center text-4xl font-bold">Create new wallet</div>
            <div class="mt-8 flex justify-center">
                <form method="post" action="/wallets/store">
                    @csrf
                    <label for="name">Wallet name:</label>
                    <input class="flex rounded-full border border-gray-800 @error('name') is-danger @enderror" name="name" value="{{ old('name') }}" required>
                    <p class="help is-danger">{{ $errors->first('name') }}</p>
                    <label for="balance">Initial balance:</label>
                    <input class="flex rounded-full border border-gray-800 @error('balance') is-danger @enderror" name="balance" value="{{ old('balance') }}" required>
                    <p class="help is-danger">{{ $errors->first('balance') }}</p>
                    <input type="hidden" name="user_id" value="{{ Auth::user()['id'] }}">
                    <button class="ml-20 mt-6 rounded-full w-24 h-8 bg-blue-300" type="submit">Create</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

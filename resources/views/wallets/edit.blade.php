<x-app-layout>
    <div class="flex justify-center">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="flex justify-center text-4xl font-bold">Edit wallet</div>
            <div class="mt-8 flex justify-center">
                <form method="POST" action="/wallets/{{ $wallet->id }}">
                    @csrf
                    @method('PUT')
                    <label for="name">Wallet name:</label>
                    <input class="flex rounded-full border border-gray-800 @error('name') is-danger @enderror" name="name" value="{{ $wallet->name }}" required>
                    <p class="help is-danger">{{ $errors->first('name') }}</p>
                    <button class="ml-20 mt-6 rounded-full w-24 h-8 bg-blue-300 border border-gray-800" type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

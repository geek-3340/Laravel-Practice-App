<x-guest-layout>
    <x-auth-card>
        <form method="POST" action="{{ route('verify.pin.store') }}">
            @csrf

            <div>
                <x-label for="two_factor_code" value="認証コード" />
                <x-input id="two_factor_code" type="text" name="two_factor_code" required autofocus />
                @error('two_factor_code')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-4">
                <x-button>認証する</x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
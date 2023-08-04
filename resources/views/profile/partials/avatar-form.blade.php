<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            User Avatar
        </h2>
        <img src="{{"storage/$user->avatar"}}" alt="Avatar Image" width=50 class="rounded-full">
        <form method="post" action="{{ route('profile.avatar.ai') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
            @csrf
            @method('patch')
            <div>
                <x-input-label for="avatar" :value="__('Generate Avatar')" />
                <x-primary-button>{{ __('Generate Avatar') }}</x-primary-button>
            </div>
        </form>
        OR
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </header>
    <form method="post" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div>
            <x-input-label for="avatar" :value="__('Upload Avatar from Computer')" />
            <x-text-input id="avatar" name="avatar" type="file" class="mt-1 block w-full" :value="old('avatar', $user->avatar)" required1 autofocus autocomplete="avatar" />
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>

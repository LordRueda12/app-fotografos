<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Teléfono')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $user->phone)" required autocomplete="phone" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Conditional Fields for Role ID 2 -->
        @if ($user->role_id == 2)
            <!-- Cedula -->
            <div class="mt-4">
                <x-input-label for="cedula" :value="__('Cédula')" />
                <x-text-input id="cedula" class="block mt-1 w-full" type="text" name="cedula" :value="old('cedula', $user->cedula)" autocomplete="cedula" />
                <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
            </div>

            <!-- Precio Foto -->
            <div class="mt-4">
                <x-input-label for="precio_foto" :value="__('Precio por Foto')" />
                <x-text-input id="precio_foto" class="block mt-1 w-full" type="number" name="precio_foto" :value="old('precio_foto', $user->precio_foto)" autocomplete="precio_foto" />
                <x-input-error :messages="$errors->get('precio_foto')" class="mt-2" />
            </div>

            <!-- Certificado -->
            <div class="mt-4">
                <x-input-label for="certificado" :value="__('Certificado')" />
                <input id="certificado" class="block mt-1 w-full" type="file" name="certificado" />
                <x-input-error :messages="$errors->get('certificado')" class="mt-2" />
            </div>

            <!-- Description -->
            <div class="mt-4">
                <x-input-label for="description" :value="__('Descripción')" />
                <textarea id="description" class="block mt-1 w-full" name="description" rows="4">{{ old('description', $user->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
        @endif

        <!-- Profile Image -->
        <div class="mt-4">
            <x-input-label for="profile_image" :value="__('Imagen de Perfil')" />
            <input id="profile_image" class="block mt-1 w-full" type="file" name="profile_image" />
            <x-input-error :messages="$errors->get('profile_image')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Guardar') }}
            </x-primary-button>
        </div>
    </form>
</section>

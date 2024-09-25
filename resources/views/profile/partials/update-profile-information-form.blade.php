<section>
    <header>
        <h2 class="h3 mb-3 text-primary">
            {{ __('Profile Information') }}
        </h2>

        <p class="mb-4 text-muted">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-4">
        @csrf
        @method('patch')

        <!-- Profile Picture Upload with Preview -->
        <div class="mb-3">
            <label for="profile_picture" class="form-label">{{ __('Profile Picture') }}</label>
            <input id="profile_picture" name="profile_picture" type="file" class="form-control" accept="image/*"
                onchange="previewImage();" />

            <!-- Display existing profile picture -->
            <div class="mt-3">
                <img id="profile_picture_preview"
                    src="{{ $user->getFirstMediaUrl('profile_pictures') ?: 'https://via.placeholder.com/150' }}"
                    alt="Profile Picture" class="img-thumbnail" width="150" height="150">
            </div>

            @if ($errors->has('profile_picture'))
                <div class="invalid-feedback">
                    @foreach ($errors->get('profile_picture') as $message)
                        {{ $message }}
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="form-control"
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @if ($errors->has('name'))
                <div class="invalid-feedback">
                    @foreach ($errors->get('name') as $message)
                        {{ $message }}
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control"
                value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @if ($errors->has('email'))
                <div class="invalid-feedback">
                    @foreach ($errors->get('email') as $message)
                        {{ $message }}
                    @endforeach
                </div>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-muted">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" type="submit" class="btn btn-link">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p class="text-success mb-0">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>

<!-- JavaScript to handle image preview -->
<script>
    function previewImage() {
        const input = document.getElementById('profile_picture');
        const preview = document.getElementById('profile_picture_preview');

        const file = input.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result; // Update the src attribute of the image
            };

            reader.readAsDataURL(file); // Read the file as a Data URL
        }
    }
</script>

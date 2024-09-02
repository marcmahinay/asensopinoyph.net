<x-guest-layout>

    <x-slot name="headerScripts">
        <!-- Layout config Js -->
        <script src="assets/js/layout.js"></script>
        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    </x-slot>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="username" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email"
                required autofocus autocomplete="email">
            @if ($errors->get('email'))
                <ul class = "text-sm text-red-600 space-y-1">
                    @foreach ((array) $errors->get('email') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="mb-3">
            {{-- <div class="float-end">
                <a href="auth-pass-reset-basic.html" class="text-muted">Forgot password?</a>
            </div> --}}
            <label class="form-label" for="password">Password</label>
            <div class="position-relative auth-pass-inputgroup mb-3">
                <input type="password" name="password" class="form-control pe-5 password-input"
                    placeholder="Enter password" id="password" required autocomplete="current-password">
                <button
                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                    type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                @if ($errors->get('password'))
                    <ul class = "text-sm text-red-600 space-y-1">
                        @foreach ((array) $errors->get('password') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
            <label class="form-check-label" for="auth-remember-check">Remember me</label>
        </div>

        <div class="mt-4">
            <button class="btn btn-success w-100" style="background-color:#ee510a; border-color:#ee510a"
                type="submit">Sign In</button>
        </div>
    </form>


    <x-slot name="footerScripts">
        <!-- particles js -->
        <script src="assets/libs/particles.js/particles.js"></script>
        <!-- particles app js -->
        <script src="assets/js/pages/particles.app.js"></script>
        <!-- password-addon init -->
        <script src="assets/js/pages/password-addon.init.js"></script>
    </x-slot>

</x-guest-layout>

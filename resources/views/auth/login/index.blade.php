@extends('auth.login.main')

@section('login')
<div class="card-body">
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="text-center mb-4">
        <a href="https://bootstrapdemos.wrappixel.com/flexy/dist/main/index.html" class="text-nowrap logo-img d-block w-100">
            <img src="https://bootstrapdemos.wrappixel.com/flexy/dist/assets/images/logos/dark-logo.svg" class="dark-logo" alt="Dark Logo" class="img-fluid" />
            <img src="https://bootstrapdemos.wrappixel.com/flexy/dist/assets/images/logos/light-logo.svg" class="light-logo d-none" alt="Light Logo" class="img-fluid" />
        </a>
    </div>

    <form method="POST" action="{{ route('auth') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">email</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            {!! NoCaptcha::renderJs('id', false, 'onloadCallback') !!}
            {!! NoCaptcha::display() !!}
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2 rounded-2">Sign In</button>
    </form>
</div>
@endsection

<script>
    var onloadCallback = function() {
        console.log("reCAPTCHA is ready!");
    };
</script>

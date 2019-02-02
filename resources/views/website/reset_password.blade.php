@extends('website.components.master')

@section('content')

    <div class="row about-container mt-3">
        <div class="col-4">

        </div>
        <div class="col-4 about">

            <form class="sign" action="{{ secure_url('reset-password') }}" method="post">
                {{ csrf_field() }}
                <label for="password" id="pass">Password</label>
                <input type="password" id="password" name="password" required>
                <label for="passwordC" id="conf">Password Confirm</label>
                <input type="password" id="passwordC" name="password_confirm" required>
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="token" value="{{ $token }}">
                <button  class="social-login form"> Reset </button>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('#passwordC').on('keyup',function () {
            $('#pass').removeClass('text-danger');
            $('#conf').removeClass('text-danger');
            if ( $('#passwordC').val().length > 1) {
                if ($('#passwordC').val() !== $('#password').val()) {
                    $('#pass').addClass('text-danger');
                    $('#conf').addClass('text-danger');
                } else if($('#passwordC').val() === $('#password').val()) {
                    $('#pass').addClass('text-success');
                    $('#conf').addClass('text-success');
                }
            }
        });
    </script>
@endsection
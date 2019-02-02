@extends('website.components.master')

@section('content')

    <div class="row about-container mt-3">
        <div class="col-4">

        </div>
        <div class="col-4 about">
            @if(count($errors))
                <h6 class="text-danger"> This email doesn't exist ,<a class="shoptizer-color" href="{{ url('sign?target=signup') }}">Sign up</a></h6>
            @endif
           <form class="sign" action="{{ url('check-mail-exist') }}" method="post">
               {{ csrf_field() }}
               <label for="email">Email</label>
               <input type="email" id="email" name="email" required>
               <button  class="social-login form"> Send </button>
           </form>
        </div>
    </div>
@endsection
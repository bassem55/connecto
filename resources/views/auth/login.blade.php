@extends('layouts.auth_master')
@section('title')
    Login
@endsection

@section('head')

    <style>
        .center
        {
            text-align: center;

        }
        .side_by_side
        {
            display: inline-block;
        }
        input[type="checkbox"] {
        -webkit-appearance: checkbox;
            -moz-appearance: checkbox;
                appearance: checkbox;
        display: inline-block;
        width: auto;
        }
    </style>
@endsection

@section('content')

    <div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title center">Login Form</h2>
                    <form method="POST" action="{{ url('/login') }}">
                       @csrf
                        <div class="input-group">
                            <label class="label center">Email</label>
                            <input class="input--style-4" type="email" value ="{{Session::get('email')}}" name="email" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                             @enderror
                        </div>
                        <div class="input-group">
                            <label class="label center">Password</label>
                            <input class="input--style-4" type="password" name="password" required>
                        </div>
                        <div class="input-group center">
                       
                            <input name ="remember_me" type="checkbox" value="1" id="rememberMe">
                            <label for="rememberMe">Remember me</label>
                            
                        </div>
                        <div class="p-t-15 center ">
                            <button class="btn btn--radius-2 btn--blue" type="submit">Login</button>
                        </div>

                       
                        <a class="center" href="{{url('/forget_password')}}">Forget Password </a><br><br>
                        <a class="center" href="{{url('/signup')}}">Do Not Have Acount Yet </a>

                        @error('error')

                        <div class="alert alert-danger center" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
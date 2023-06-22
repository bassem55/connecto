@extends('layouts.auth_master')
@section('title')
    Forget Password
@endsection

@section('head')

    <style>
        .center
        {
            text-align: center;

        }
    </style>
@endsection

@section('content') 


<div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                

                <div class="card-body">
                    <h2 class="title center">Forget Password </h2>
                    <form method="POST" action="{{ url('/forget_password') }}">
                       @csrf
                        <div class="input-group">
                            <label class="label center">Enter Your Email</label>
                            <input class="input--style-4" type="email" value ="{{Session::get('email')}}" name="email" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                             @enderror
                        </div>
                        <div class="p-t-15 center ">
                            <button class="btn btn--radius-2 btn--blue" type="submit">Continue</button>
                        </div>
                       
                        <a class="center" href="{{url('/login')}}">Try Login Again </a><br><br>
                        <a class="center" href="{{url('/signup')}}">Do Not Have Acount Yet </a>

                        @error('error')

                        <div class="alert alert-danger center" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </form>
                    @if(Session::has('msg'))
                        <div class="alert alert-primary center" role="alert">
                        {{ Session::get('msg') }}
                        </div>
                 @endif
                </div>
            </div>
        </div>
    </div>

@endsection
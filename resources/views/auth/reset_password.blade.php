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
        .hidden
        {
            display:none;
        }
    </style>
@endsection

@section('content') 

<div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title center">Forget Password </h2>
                    <form method="POST" action="{{ url('/reset_password') }}">
                       @csrf
                       <input type="hidden"  name="token"  value = "{{$token}}">
                        <div class="input-group">
                            <label class="label">Password</label>
                                        <input class="input--style-4" type="password" name="password" required autocomplete="new-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                        </div>
                        <div class="input-group">
                            <label class="label">Repassword</label>
                            <input class="input--style-4" type="password" name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <div class="p-t-15 center ">
                            <button class="btn btn--radius-2 btn--blue" type="submit">Save</button>
                        </div>
                        

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
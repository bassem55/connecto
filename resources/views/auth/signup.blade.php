@extends('layouts.auth_master')
@section('title')
    Register
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
                    <h2 class="title">Registration Form</h2>
                    <form method="POST" action="{{url('/signup')}}">
                        @csrf
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">name</label>
                                    <input class="input--style-4" required type="text" name="name" min="4" max="20" value="{{Session::get('name')}}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                               
                            </div>
                          

                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Phone Number</label>
                                    <input class="input--style-4" required type="number" name="phone" value="{{Session::get('phone')}}">

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                     @enderror
                                </div>
                               
                            </div>
                           
                            
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Email</label>
                                    <input class="input--style-4" type="email" required name="email" value="{{Session::get('email')}}">
                                   
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                     @enderror
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Birthday</label>
                                    <div class="input-group-icon">
                                        <input class="input--style-4 js-datepicker" required type="text" name="birthday" value="{{Session::get('birthday')}}">
                                        <i class="zmdi zmdi-calendar-note input-icon js-btn-calendar"></i>
                                        @error('birthday')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                           


                        </div>
                        <div class="row row-space">

                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Password</label>
                                    <input class="input--style-4" type="password" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                           
                            

                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Repassword</label>
                                    <input class="input--style-4" type="password" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                           
                           
                            <!--
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Gender</label>
                                    <div class="p-t-10">
                                        <label class="radio-container m-r-45">Male
                                            <input type="radio" checked="checked" name="gender">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container">Female
                                            <input type="radio" name="gender">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            -->
                        </div>
                        
                       
                        <div class="p-t-15 center">
                            <button class="btn btn--radius-2 btn--blue" type="submit">Register</button>
                        </div>
                    </form>

                    <a class="center" href="{{url('/login')}}">Already Have Acount </a>
                </div>
            </div>
        </div>
    </div>

@endsection


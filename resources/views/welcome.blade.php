@extends('layouts.master')
@section('title')
Welcome
@endsection
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @include('includes.message-block')
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 screen-signup">
            <h3>Sign Up</h3>
            {!! Form::open(array('route' => 'signup')) !!}
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    {!! Form::label('Email') !!}
                    {!! Form::email('email', old('email'), array('class' => 'form-control', 'id' => 'email')) !!}
                </div>
                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                    {!! Form::label('first_name') !!}
                    {!! Form::text('first_name', old('first_name'), array('class' => 'form-control', 'id' => 'first_name')) !!}
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    {!! Form::label('password') !!}
                    {!! Form::password('password', old('password'), array('class' => 'form-control', 'id' => 'password')) !!}
                </div>
                {!! Form::submit('Sign Up', array('class' => 'btn btn-primary')) !!}
                {!! Form::button('Clear', array('class' => 'btn btn-warning btn-reset-signup')) !!}
            {!! Form::close() !!}
        </div>

        <div class="col-md-6 screen-signin">
            <h3>Sign In</h3>
            {!! Form::open(array('route' => 'signin')) !!}
            <div class="form-group {{ $errors->has('email_signin') ? 'has-error' : '' }}">
                {!! Form::label('Email') !!}
                {!! Form::email('email_signin', old('email_signin'), array('class' => 'form-control', 'id' => 'email_signin')) !!}
            </div>
            <div class="form-group {{ $errors->has('password_signin') ? 'has-error' : '' }}">
                {!! Form::label('password_signin') !!}
                {!! Form::password('password_signin', old('password_signin'), array('class' => 'form-control', 'id' => 'password_signin')) !!}
            </div>
            {!! Form::submit('Login', array('class' => 'btn btn-primary')) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
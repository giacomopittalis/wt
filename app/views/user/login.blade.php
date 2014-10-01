@extends('layouts.login')

@section('content')
<div class="login-wrapper">
    <h1>Admin login</h1>
    <p>Please log in to manage clients</p>
    @include('partials.notification')
    {{ Form::open(array('route' => 'do_login', 'class' => 'login')) }}
    <form class="login">
        <div class="form-group">
            <span class="icon email"></span>
            <input type="text" name="email" class="form-control" placeholder="Email">
        </div>
        <div class="form-group">
            <span class="icon password"></span>
            <input type="password" name="password" class="form-control" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-large btn-normal">Sign in</button>
        <div class="left">
            <input type="checkbox" name="remember" value="true"><span class="remind">Remember me</span>
        </div>
    {{ Form::close() }}
    <div class="right">
        <a href="#">Need help?</a>
    </div>
    <div class="clear"></div>
</div>
@stop
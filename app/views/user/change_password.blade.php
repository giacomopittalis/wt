@extends('layouts.main')

@section('page-title')
    Change Password
@stop

@section('content')
	{{ Form::open(array('route' => 'change-password','id' => 'create-employee')) }}
		@include('partials.notification')
        <div class="form-section">
            <div class="row">
                <div class="col-sm-4">
                    <h3>Change Password</h3>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Old Password</label><br>
                        <input type="password" name="old_password" class="form-control">
                        @include('partials.error-message',array('field' => 'old_password'))
                    </div>
                    <div class="form-group">
                        <label>New Password</label><br>
                        <input type="password" name="new_password" class="form-control">
                        @include('partials.error-message',array('field' => 'new_password'))
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label><br>
                        <input type="password" name="confirm_password" class="form-control">
                        @include('partials.error-message',array('field' => 'confirm_password'))
                    </div>
                </div>
            </div>
        </div>
        <div class="submit-section">
            {{ Form::submit('Change Password',array('class' => 'btn btn-submit right')) }}
            <button type="button" class="btn btn-cancel right">Cancel</button>
            <div class="clear"></div>
        </div>
    {{ Form::close() }}
@stop
@extends('layouts.main')

@section('page-title')
    My Profile
@stop

@section('content')
	{{ Form::open(array('route' => 'profile','id' => 'create-employee', 'files' => true)) }}
		@include('partials.notification')
        <div class="form-section">
            <div class="row">
                <div class="col-sm-4">
                    <h3>User Information</h3>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>First Name</label><br>
                        {{ Form::text('first_name',$user->first_name,array('class' => 'form-control')) }}
                        @include('partials.error-message',array('field' => 'first_name'))
                    </div>
                    <div class="form-group">
                        <label>Last Name</label><br>
                        {{ Form::text('last_name',$user->last_name,array('class' => 'form-control')) }}
                        @include('partials.error-message',array('field' => 'last_name'))
                    </div>
                </div>
            </div>
        </div>
        <div class="form-section">
            <div class="row">
                <div class="col-sm-4">
                    <h3>Identification</h3>
                    <p>Use any description here as you want</p>
                    <p>(e.g. Upload a picture)</p>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        @if($identification)
                            <img src="{{ $identification->value }}" width="285"><br><br>
                        @endif
                        {{ Form::file('identification',array('class' => 'form-control')) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="submit-section">
            {{ Form::submit('Save',array('class' => 'btn btn-submit right')) }}
            <button type="button" class="btn btn-cancel right">Cancel</button>
            <div class="clear"></div>
        </div>
    {{ Form::close() }}
@stop
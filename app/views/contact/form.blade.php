@extends('layouts.main')

@section('page-title')
	Create Contact
@stop

@section('content')
	{{ Form::open(array('route' => 'contact.store','id' => 'create-employee')) }}
		@include('partials.notification')
        <div class="form-section">
            <div class="row">
                <div class="col-sm-4">
                    <h3>Contact Information</h3>
                </div>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Client <span class="text-danger">*</span></label><br>
                                {{ Form::select('client_id',AppHelper::getClients()) }}
                                @include('partials.error-message',array('field' => 'client_id'))
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Location <span class="text-danger">*</span></label><br>
                                {{ Form::select('location_id',AppHelper::getLocations()) }}
                                @include('partials.error-message',array('field' => 'location_id'))
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Select Mode <span class="text-danger">*</span></label><br>
                                {{ Form::select('mode',AppHelper::getContactMode()) }} 
                                @include('partials.error-message',array('field' => 'mode')) 
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Contact Method <span class="text-danger">*</span></label><br>
                                {{ Form::select('method',AppHelper::getContactMethod()) }}  
                                @include('partials.error-message',array('field' => 'method'))
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Employee <span class="text-danger">*</span></label><br>
                                {{ Form::select('employee_id',AppHelper::getEmployees()) }}  
                                @include('partials.error-message',array('field' => 'employee_id'))
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group date">
                                <label>Date</label><br>
                                {{ Form::select('year',AppHelper::getYear(0,2,'Year','+')) }}  
                                {{ Form::select('month',AppHelper::getMonth()) }}  
                                {{ Form::select('day',AppHelper::getDay()) }}  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="submit-section">
        	{{ Form::hidden('contact_id',(isset($contact->id) ? $contact->id : '')) }}
        	{{ Form::submit('Create',array('class' => 'btn btn-submit right')) }}
            <button type="button" class="btn btn-cancel right">Cancel</button>
            <div class="clear"></div>
        </div>
    {{ Form::close() }}
@stop
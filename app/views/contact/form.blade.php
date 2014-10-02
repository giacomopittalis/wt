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
                                <label>Client</label><br>
                                {{ Form::select('client_id',AppHelper::getClients()) }}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Location</label><br>
                                {{ Form::select('location_id',AppHelper::getLocations()) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Select Mode</label><br>
                                {{ Form::select('mode',AppHelper::getContactMode()) }}  
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Contact Method</label><br>
                                {{ Form::select('method',AppHelper::getContactMethod()) }}  
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Employee</label><br>
                                {{ Form::select('employee_id',AppHelper::getEmployees()) }}  
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
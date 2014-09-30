@extends('layouts.main')

@section('page-title')
	New Well Credit Consult
@stop

@section('content')
	{{ Form::open(array('route' => 'well-credit-consult.store','id' => 'create-employee')) }}
		@include('partials.notification')
        <div class="form-section">
            <div class="row">
                <div class="col-sm-4">
                    <h3>Information</h3>
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
                                <label>Contact ID</label><br>
                                {{ Form::select('employee_id',AppHelper::getEmployees('Select Contact ID')) }}
                            </div>
                        </div>
                    </div>
                    <div class="line-separator"></div>
                    <input type="checkbox" name="comment[]" value="1"><span class="checkbox-label">20 Mile Jog</span><br>
                    <input type="checkbox" name="comment[]" value="2"><span class="checkbox-label">100 pushups</span><br>
                    <input type="checkbox" name="comment[]" value="3"><span class="checkbox-label">30 Minutes Aerobics</span><br>
                </div>
            </div>
        </div>
        <div class="submit-section">
        	{{ Form::hidden('health_consult_id',(isset($health_consult->id) ? $health_consult->id : '')) }}
        	{{ Form::submit('Create',array('class' => 'btn btn-submit right')) }}
            <button type="button" class="btn btn-cancel right">Cancel</button>
            <div class="clear"></div>
        </div>
    {{ Form::close() }}
@stop
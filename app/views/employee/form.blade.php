@extends('layouts.main')

@section('page-title')
	Create Employee
@stop

@section('content')
	{{ Form::open(array('route' => 'employee.store','id' => 'create-employee', 'files' => true)) }}
		{{ Notification::showAll() }}
		@if($errors->all())
			<div class="form-section">
			@foreach($errors->all() as $message)
				<div class="row">
					<div class="col-sm-12">
						<div class="alert alert-danger" role="alert">
					    	{{ $message }}
					    </div>
					</div>
				</div>
			@endforeach
			</div>
		@endif
        <div class="form-section">
            <div class="row">
                <div class="col-sm-4">
                    <h3>Hierarchy</h3>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Client</label><br />
                        {{ Form::select('client_id',AppHelper::getClients()) }}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Location</label><br />
                        {{ Form::select('location_id',AppHelper::getLocations()) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="form-section">
            <div class="row">
                <div class="col-sm-4">
                    <h3>Nomenclature</h3>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>First Name</label><br />
                        {{ Form::text('first_name','',array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group">
                        <label>Middle Name</label><br />
                        {{ Form::text('middle_name','',array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group">
                        <label>Last Name</label><br />
                        {{ Form::text('last_name','',array('class' => 'form-control')) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="form-section">
            <div class="row">
                <div class="col-sm-4">
                    <h3>Personal Demographics</h3>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Sex</label><br />
                        {{ Form::select('sex',AppHelper::getSex()) }}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group birthdate">
                        <label>Date of Birth</label><br />
                        {{ Form::select('dob_year',AppHelper::getYear()) }}
                        {{ Form::select('dob_month',AppHelper::getMonth()) }}
                        {{ Form::select('dob_day',AppHelper::getDay()) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="form-section">
            <div class="row">
                <div class="col-sm-4">
                    <h3>Official Demographics</h3>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Department</label><br />
                        {{ Form::text('department','',array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group">
                        <label>Position</label><br />
                        {{ Form::text('position','',array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group">
                        <label>Employee Number</label><br />
                        {{ Form::text('employee_number','',array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group">
                        <label>Hire Year</label><br />
                        {{ Form::select('hire_year',AppHelper::getYear(0,20,'Select Hire Year')) }}
                    </div>
                    <div class="form-group">
                        <label>Hire Type</label><br />
                        {{ Form::select('hire_type',AppHelper::getHireType()) }}
                    </div>
                    <div class="form-group">
                        <label>Health Plan</label><br />
                        {{ Form::text('health_plan','',array('class' => 'form-control')) }}
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
                    	{{ Form::file('identification',array('class' => 'form-control')) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="submit-section">
        	{{ Form::hidden('employee_id',(isset($employee->id) ? $employee->id : '')) }}
        	{{ Form::submit('Create',array('class' => 'btn btn-submit right')) }}
            <button type="button" class="btn btn-cancel right">Cancel</button>
            <div class="clear"></div>
        </div>
    {{ Form::close() }}
@stop
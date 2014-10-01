@extends('layouts.main')

@section('page-title')
    @if($action == 'create')
	   Create Employee
    @else
       Edit Employee
    @endif
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
        @if($action == 'create')
            @include('employee._partials.create-employee-hierarchy')
        @else
            @include('employee._partials.edit-employee-hierarchy')
        @endif
        <div class="form-section">
            <div class="row">
                <div class="col-sm-4">
                    <h3>Nomenclature</h3>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>First Name</label><br />
                        {{ Form::text('first_name','',array('class' => 'form-control', 'id' => 'first_name')) }}
                    </div>
                    <div class="form-group">
                        <label>Middle Name</label><br />
                        {{ Form::text('middle_name','',array('class' => 'form-control', 'id' => 'middle_name')) }}
                    </div>
                    <div class="form-group">
                        <label>Last Name</label><br />
                        {{ Form::text('last_name','',array('class' => 'form-control', 'id' => 'last_name')) }}
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
                        {{ Form::select('sex',AppHelper::getSex(),'',array('id'=>'sex')) }}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group birthdate">
                        <label>Date of Birth</label><br />
                        {{ Form::select('dob_year',AppHelper::getYear(),'',array('id'=>'dob_year')) }}
                        {{ Form::select('dob_month',AppHelper::getMonth(),'',array('id'=>'dob_month')) }}
                        {{ Form::select('dob_day',AppHelper::getDay(),'',array('id'=>'dob_day')) }}
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
                        {{ Form::text('department','',array('class' => 'form-control','id'=>'department')) }}
                    </div>
                    <div class="form-group">
                        <label>Position</label><br />
                        {{ Form::text('position','',array('class' => 'form-control','id'=>'position')) }}
                    </div>
                    <div class="form-group">
                        <label>Employee Number</label><br />
                        {{ Form::text('employee_number','',array('class' => 'form-control','id'=>'employee_number')) }}
                    </div>
                    <div class="form-group">
                        <label>Hire Year</label><br />
                        {{ Form::select('hire_year',AppHelper::getYear(0,20,'Select Hire Year'),'',array('id'=>'hire_year')) }}
                    </div>
                    <div class="form-group">
                        <label>Hire Type</label><br />
                        {{ Form::select('hire_type',AppHelper::getHireType(),'',array('id'=>'hire_type')) }}
                    </div>
                    <div class="form-group">
                        <label>Health Plan</label><br />
                        {{ Form::text('health_plan','',array('class' => 'form-control','id'=>'health_plan')) }}
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
        	{{ Form::hidden('employee_id',(isset($employee->id) ? $employee->id : ''),array('id'=>'employee_id')) }}
        	{{ Form::submit('Create',array('class' => 'btn btn-submit right')) }}
            <button type="button" class="btn btn-cancel right">Cancel</button>
            <div class="clear"></div>
        </div>
    {{ Form::close() }}
@stop
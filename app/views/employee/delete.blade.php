@extends('layouts.main')

@section('page-title')
    Delete Employee
@stop

@section('content')
	{{ Form::open(array('route' => 'employee.do_delete','id' => 'create-employee')) }}
		@include('partials.notification')
        @include('employee._partials.edit-employee-hierarchy')
        <div class="submit-section">
        	{{ Form::hidden('employee_id',(isset($employee->id) ? $employee->id : ''),array('id'=>'employee_id')) }}
        	{{ Form::submit('Create',array('class' => 'btn btn-submit right')) }}
            <button type="button" class="btn btn-cancel right">Cancel</button>
            <div class="clear"></div>
        </div>
    {{ Form::close() }}
@stop
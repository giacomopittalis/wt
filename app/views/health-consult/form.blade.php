@extends('layouts.main')

@section('page-title')
    @if($action == 'create')
	New Health Consult
    @else
    Edit Health Consult
    @endif
@stop

@section('content')
	{{ Form::open(array('route' => 'health-consult.store','id' => 'create-employee')) }}
		@include('partials.notification')
        @include('partials.forms.client-information',array('action'=>$action,'contact_id'=>'contact_id_health'))
        @include('health-consult._partials.info')
        @include('health-consult._partials.notes')
        <div class="submit-section">
        	{{ Form::hidden('health_consult_id','') }}
            @if($action == 'edit')
                {{ Form::submit('Save',array('class' => 'btn btn-submit right')) }}
            @else
                {{ Form::submit(ucfirst($action),array('class' => 'btn btn-submit right')) }}
            @endif
            <button type="button" class="btn btn-cancel right">Cancel</button>
            <div class="clear"></div>
        </div>
    {{ Form::close() }}
@stop
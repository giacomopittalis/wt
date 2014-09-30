@extends('layouts.main')

@section('page-title')
	New Injury Consult
@stop

@section('content')
	{{ Form::open(array('route' => 'health-consult.store','id' => 'create-employee')) }}
		@include('partials.notification')
        @include('injury-consult._partials.client-information')
        @include('injury-consult._partials.info')
        @include('injury-consult._partials.notes')
        <div class="submit-section">
        	{{ Form::hidden('health_consult_id',(isset($health_consult->id) ? $health_consult->id : '')) }}
        	{{ Form::submit('Create',array('class' => 'btn btn-submit right')) }}
            <button type="button" class="btn btn-cancel right">Cancel</button>
            <div class="clear"></div>
        </div>
    {{ Form::close() }}
@stop
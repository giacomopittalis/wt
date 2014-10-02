@extends('layouts.main')

@section('page-title')
    @if($action == 'create')
	New Injury Consult
    @else
    Edit Injury Consult
    @endif
@stop

@section('content')
	{{ Form::open(array('route' => 'health-consult.store','id' => 'create-employee')) }}
		@include('partials.notification')
        @include('injury-consult._partials.client-information')
        @include('injury-consult._partials.info')
        @include('injury-consult._partials.notes')
        <div class="submit-section">
        	{{ Form::hidden('id','') }}
        	{{ Form::submit(ucfirst($action),array('class' => 'btn btn-submit right')) }}
            <button type="button" class="btn btn-cancel right">Cancel</button>
            <div class="clear"></div>
        </div>
    {{ Form::close() }}
@stop
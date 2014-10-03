@extends('layouts.main')

@section('page-title')
    @if($action == 'create')
	New Injury Consult
    @else
    Edit Injury Consult
    @endif
@stop

@section('content')
	{{ Form::open(array('route' => 'injury-consult.store','id' => 'create-employee')) }}
		@include('partials.notification')
        @include('partials.forms.client-information',array('action'=>$action,'contact_id'=>'contact_id_injury'))
        @include('injury-consult._partials.info')
        @include('injury-consult._partials.notes')
        <div class="submit-section">
        	@if($action == 'edit')
                {{ Form::hidden('id','') }}
                {{ Form::submit('Save',array('class' => 'btn btn-submit right')) }}
            @else
                {{ Form::submit(ucfirst($action),array('class' => 'btn btn-submit right')) }}
            @endif
            <button type="button" class="btn btn-cancel right">Cancel</button>
            <div class="clear"></div>
        </div>
    {{ Form::close() }}
@stop
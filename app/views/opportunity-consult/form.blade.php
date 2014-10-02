@extends('layouts.main')

@section('page-title')
    @if($action == 'create')
	New Opportunity Consult
    @else
    Edit Opportuniy Consult
    @endif
@stop

@section('content')
	{{ Form::open(array('route' => 'opportunity-consult.store','id' => 'create-employee')) }}
		@include('partials.notification')
        @include('partials.forms.client-information',array('action' => $action,'id'=>'contact_id_opportunity'))
        <div class="form-section">
            <div class="row">
                <div class="col-sm-4">
                    <h3>Comment</h3>
                </div>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-12">
                            <textarea name="comment" id="comment"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('partials.forms.notes')
        <div class="submit-section">
            @if($action == 'edit')
        	{{ Form::hidden('id','') }}
            @endif
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
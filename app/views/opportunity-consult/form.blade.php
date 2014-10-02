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
        	{{ Form::hidden('id','') }}
        	{{ Form::submit(ucfirst($action),array('class' => 'btn btn-submit right')) }}
            <button type="button" class="btn btn-cancel right">Cancel</button>
            <div class="clear"></div>
        </div>
    {{ Form::close() }}
@stop
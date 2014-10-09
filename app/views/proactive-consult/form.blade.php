@extends('layouts.main')

@section('page-title')
    @if($action == 'create')
    New Proactive Consult
    @else
    Edit Proactive Consult
    @endif
@stop

@section('content')
	{{ Form::open(array('route' => 'proactive-consult.store','id' => 'create-employee')) }}
		@include('partials.notification')
        @include('partials.forms.client-information',array('action'=>$action,'contact_id'=>'contact_id_proactive'))
        <div class="form-section">
            <div class="row">
                <div class="col-sm-4">
                    <h3>Comment</h3>
                </div>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Select Comments</label><br>
                                <select name="type" id="type">
                                    <option value="0" disabled="" selected="">Please Select</option>
                                    <option value="comment-1">Comment 1</option>
                                    <option value="comment-2">Comment 2</option>
                                </select>
                            </div>
                        </div>
                    </div>
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
        	{{ Form::hidden('proactive_consult_id','') }}
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
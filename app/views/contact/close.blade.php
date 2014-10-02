@extends('layouts.main')

@section('page-title')
	Close Contact
@stop

@section('content')
	{{ Form::open(array('route' => 'contact.do_close','id' => 'create-employee','method' => 'post')) }}
		@include('partials.notification')
        <div class="form-section">
            <div class="row">
                <div class="col-sm-4">
                    <h3>Contact Information</h3>
                </div>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Client</label><br>
                                {{ Form::select('client_id',AppHelper::getClients(),'',array('id'=>'client_id')) }}
                            </div>
                            <div class="form-group">
                                <label>Location</label><br>
                                {{ Form::select('location_id',AppHelper::getLocations(),'',array('id'=>'location_id')) }}
                            </div>
                            <div class="form-group">
                                <label>Contact</label><br>
                                <select name="contact_id" id="contact_id">
                                    <option value="0" disabled="" selected="">Select Contact ID</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="submit-section">
        	{{ Form::hidden('contact_id',(isset($contact->id) ? $contact->id : '')) }}
        	{{ Form::submit('Close',array('class' => 'btn btn-delete right')) }}
            <button type="button" class="btn btn-cancel right">Cancel</button>
            <div class="clear"></div>
        </div>
    {{ Form::close() }}
@stop
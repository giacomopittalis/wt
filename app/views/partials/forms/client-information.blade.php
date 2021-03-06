<div class="form-section">
    <div class="row">
        <div class="col-sm-4">
            <h3>Client Information</h3>
        </div>
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Client <span class="text-danger">*</span></label><br>
                        {{ Form::select('client_id',AppHelper::getClients(),'',array('id'=>'client_id')) }}
                        @include('partials.error-message',array('field' => 'client_id'))
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Location <span class="text-danger">*</span></label><br>
                        {{ Form::select('location_id',AppHelper::getLocations(),'',array('id'=>'location_id')) }}
                        @include('partials.error-message',array('field' => 'location_id'))
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Contact ID <span class="text-danger">*</span></label><br>
                        @if(isset($action) && $action == 'edit')
                        {{ Form::select('contact_id',array('Select Contact ID'),'',array('id' => ((isset($contact_id) ? $contact_id : 'contact_id')))) }}
                        @else
                        {{ Form::select('contact_id',array('Select Contact ID'),'',array('id' => 'contact_id')) }}
                        @endif
                        @include('partials.error-message',array('field' => 'contact_id'))
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <input type="checkbox" name="under_medical_care" id="under_medical_care" value="1"><span class="checkbox-label">Under Medical Care</span>
                </div>
            </div>
        </div>
    </div>
</div>
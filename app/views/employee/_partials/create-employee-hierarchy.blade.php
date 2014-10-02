<div class="form-section">
    <div class="row">
        <div class="col-sm-4">
            <h3>Hierarchy</h3>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Client <span class="text-danger">*</span></label><br />
                {{ Form::select('client_id',AppHelper::getClients()) }}
                @include('partials.error-message',array('field' => 'client_id'))
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Location <span class="text-danger">*</span></label><br />
                {{ Form::select('location_id',AppHelper::getLocations()) }}
                @include('partials.error-message',array('field' => 'location_id'))
            </div>
        </div>
    </div>
</div>
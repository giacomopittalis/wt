<div class="form-section">
    <div class="row">
        <div class="col-sm-4">
            <h3>Hierarchy</h3>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Client</label><br />
                {{ Form::select('client_id',AppHelper::getClients()) }}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Location</label><br />
                {{ Form::select('location_id',AppHelper::getLocations()) }}
            </div>
        </div>
    </div>
</div>
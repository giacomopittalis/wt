<div class="form-section">
    <div class="row">
        <div class="col-sm-4">
            <h3>Client Information</h3>
        </div>
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Client</label><br>
                        {{ Form::select('client_id',AppHelper::getClients()) }}
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Location</label><br>
                        {{ Form::select('location_id',AppHelper::getLocations()) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Contact ID</label><br>
                        {{ Form::select('employee_id',array('Select Contact ID'),'array') }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <input type="checkbox" name="under_medical_care" value="1"><span class="checkbox-label">Under Medical Care</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-section">
    <div class="row">
        <div class="col-sm-4">
            <h3>Hierarchy</h3>
        </div>
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Client</label><br>
                        {{ Form::select('client_id',AppHelper::getClients(),'',array('id' => 'client_id_employee')) }}
                        @include('partials.error-message',array('field' => 'client_id'))
                    </div>
                    <div class="form-group">
                        <label>Location</label><br>
                        {{ Form::select('location_id',AppHelper::getLocations(),'',array('id' => 'location_id_employee')) }}
                        @include('partials.error-message',array('field' => 'location_id'))
                    </div>
                    <div class="form-group">
                        <label>Employee</label><br>
                        <select name="employee_id" id="employee_id">
                            <option value="0" disabled="" selected="">Select Employee</option>
                        </select>
                        @include('partials.error-message',array('field' => 'employee_id'))
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
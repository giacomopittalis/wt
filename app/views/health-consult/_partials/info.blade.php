<div class="form-section">
    <div class="row">
        <div class="col-sm-4">
            <ul class="consult-list">
                <li id="info-btn" class="active">Info</li>
                <li id="topic-btn">Topics</li>
                <li id="soap-btn">SOAP</li>
            </ul>
        </div>
        <div class="col-sm-8">
            <div id="info">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Height (cm)</label><br>
                            {{ Form::text('info[height]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Weight (kg)</label><br>
                            {{ Form::text('info[weight]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>BMI</label><br>
                            {{ Form::text('info[bmi]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Body Fat (Segmental)</label><br>
                            {{ Form::text('info[body_fat]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Hydration</label><br>
                            {{ Form::text('info[hydration]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>BMR (metabolic Age)</label><br>
                            {{ Form::text('info[bmr]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Visceral Fat</label><br>
                            {{ Form::text('info[visceral_fat]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Bone Mass</label><br>
                            {{ Form::text('info[bone_mass]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Muscle Mass (Segmental)</label><br>
                            {{ Form::text('info[muscle_mass]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Waist Circumference</label><br>
                            {{ Form::text('info[waist_circumference]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Hip Circumference</label><br>
                            {{ Form::text('info[hip_circumference]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Thigh Circumference</label><br>
                            {{ Form::text('info[thigh_circumference]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Arm Circumference</label><br>
                            {{ Form::text('info[arm_circumference]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Chest Circumference</label><br>
                            {{ Form::text('info[chest_circumference]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Blood Pressure (Systolic)</label><br>
                            {{ Form::text('info[systolic]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Blood Pressure (Diastolic)</label><br>
                            {{ Form::text('info[diastolic]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Heart Rate</label><br>
                            {{ Form::text('info[heart_rate]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Blood Sugar (Glucose)</label><br>
                            {{ Form::text('info[glucose]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Total CHO</label><br>
                            {{ Form::text('info[total_cho]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>HDL</label><br>
                            {{ Form::text('info[hdl]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>LDL</label><br>
                            {{ Form::text('info[ldl]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Ratio</label><br>
                            {{ Form::text('info[ratio]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Triglycerides</label><br>
                            {{ Form::text('info[triglycerides]','',array('class' => 'form-control')) }}
                        </div>
                    </div>
                </div>
            </div>
            <div id="topic">
                <div class="row">
                    <div class="col-sm-12">
                        @foreach(AppHelper::getHealthTopic() as $key => $value)
                        <input type="checkbox" name="topic[]" value="{{ $key }}"><span class="checkbox-label">{{ $value }}</span><br>
                        @endforeach
                    </div>
                </div>
            </div>
            <div id="soap">
                <div class="row">
                    <div class="col-sm-12">
                        @foreach(AppHelper::getHealthSOAP() as $key => $value)
                        <input type="checkbox" name="soap[]" value="{{ $key }}"><span class="checkbox-label">{{ $value }}</span><br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
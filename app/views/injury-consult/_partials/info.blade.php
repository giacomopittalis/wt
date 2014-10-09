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
                <input type="checkbox" name="info[general][work][]" value="1"><span class="checkbox-label">Work vs. Non Work - Check for work</span><br>
                <input type="checkbox" name="info[general][work][]" value="2"><span class="checkbox-label">Existing vs. Pre Existing - Check for Existing</span><br>
                <div class="line-separator"></div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>MOI</label><br>
                            <textarea name="info[general][moi]"></textarea>
                        </div>
                    </div>
                </div>
                <div class="line-separator"></div>
                <div class="row">
                    <div class="col-sm-3">
                        <input type="checkbox" name="info[general][criteria][]" value="1"><span class="checkbox-label">Acute</span><br>
                        <input type="checkbox" name="info[general][criteria][]" value="2"><span class="checkbox-label">Overuse</span><br>
                        <input type="checkbox" name="info[general][criteria][]" value="3"><span class="checkbox-label">Over Stretching</span><br>
                    </div>
                    <div class="col-sm-3">
                        <input type="checkbox" name="info[general][criteria][]" value="4"><span class="checkbox-label">Chronic</span><br>
                        <input type="checkbox" name="info[general][criteria][]" value="5"><span class="checkbox-label">Twisting</span><br>
                        <input type="checkbox" name="info[general][criteria][]" value="6"><span class="checkbox-label">Slip/Fall</span><br>
                    </div>
                    <div class="col-sm-3">
                        <input type="checkbox" name="info[general][criteria][]" value="7"><span class="checkbox-label">Blunt Trauma</span><br>
                        <input type="checkbox" name="info[general][criteria][]" value="8"><span class="checkbox-label">Sheer Force</span><br>
                        <input type="checkbox" name="info[general][criteria][]" value="9"><span class="checkbox-label">Equipment</span><br>
                    </div>
                    <div class="col-sm-3">
                        <input type="checkbox" name="info[general][criteria][]" value="10"><span class="checkbox-label">Caught Between</span><br>
                        <input type="checkbox" name="info[general][criteria][]" value="11"><span class="checkbox-label">Over Exertion</span><br>
                        <input type="checkbox" name="info[general][criteria][]" value="12"><span class="checkbox-label">Other</span><br>
                    </div>
                </div>
                <div class="line-separator"></div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Pain Level</label><br>
                            <select name="info[pain_level][general]">
                                <option value="0" disabled="" selected="">Select Pain Level</option>
                                <option value="1">Lorem Ipsum</option>
                                <option value="2">Dolor Sit Amet</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <input type="checkbox" name="info[pain_level][criteria][]" value="1"><span class="checkbox-label">Acute</span><br>
                        <input type="checkbox" name="info[pain_level][criteria][]" value="2"><span class="checkbox-label">Overuse</span><br>
                        <input type="checkbox" name="info[pain_level][criteria][]" value="3"><span class="checkbox-label">Over Stretching</span><br>
                    </div>
                    <div class="col-sm-3">
                        <input type="checkbox" name="info[pain_level][criteria][]" value="4"><span class="checkbox-label">Chronic</span><br>
                        <input type="checkbox" name="info[pain_level][criteria][]" value="5"><span class="checkbox-label">Twisting</span><br>
                        <input type="checkbox" name="info[pain_level][criteria][]" value="6"><span class="checkbox-label">Slip/Fall</span><br>
                    </div>
                    <div class="col-sm-3">
                        <input type="checkbox" name="info[pain_level][criteria][]" value="7"><span class="checkbox-label">Blunt Trauma</span><br>
                        <input type="checkbox" name="info[pain_level][criteria][]" value="8"><span class="checkbox-label">Sheer Force</span><br>
                        <input type="checkbox" name="info[pain_level][criteria][]" value="9"><span class="checkbox-label">Equipment</span><br>
                    </div>
                    <div class="col-sm-3">
                        <input type="checkbox" name="info[pain_level][criteria][]" value="10"><span class="checkbox-label">Caught Between</span><br>
                        <input type="checkbox" name="info[pain_level][criteria][]" value="11"><span class="checkbox-label">Over Exertion</span><br>
                        <input type="checkbox" name="info[pain_level][criteria][]" value="12"><span class="checkbox-label">Other</span><br>
                    </div>
                </div>
                <div class="line-separator"></div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Lost Time</label><br>
                            <input type="text" name="info[lost_time]" value="" class="form-control">
                        </div>
                        <input type="checkbox" name="info[md_seen]" value="1"><span class="checkbox-label">MD Seen</span><br>
                        <div class="form-group">
                            <label>Body Part</label><br>
                            <select name="info[body_part]">
                                <option value="0" disabled="" selected="">Select Body Part</option>
                                <option value="1">Lorem Ipsum</option>
                                <option value="2">Dolor Sit Amet</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Injury Type</label><br>
                            <select name="info[injury_type]">
                                <option value="0" disabled="" selected="">Select Injury Type</option>
                                <option value="1">Lorem Ipsum</option>
                                <option value="2">Dolor Sit Amet</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Severity Rate</label><br>
                            <select name="info[severity_rate]">
                                <option value="0" disabled="" selected="">Select Severity Rate</option>
                                <option value="1">Lorem Ipsum</option>
                                <option value="2">Dolor Sit Amet</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Pain Rate</label><br>
                            <select name="info[pain_rate]">
                                <option value="0" disabled="" selected="">Select Pain Rate</option>
                                <option value="1">Lorem Ipsum</option>
                                <option value="2">Dolor Sit Amet</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Improvement Level</label><br>
                            <select name="info[improvement_level]">
                                <option value="0" disabled="" selected="">Select Improvement Level</option>
                                <option value="1">Lorem Ipsum</option>
                                <option value="2">Dolor Sit Amet</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div id="topic">
                <div class="row">
                    <div class="col-sm-12">
                        @foreach(AppHelper::getInjuryTopic() as $key => $value)
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
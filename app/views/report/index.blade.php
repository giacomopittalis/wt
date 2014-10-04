@extends('layouts.main')

@section('page-title')
    Data Export
@stop

@section('content')
    {{ Form::open(array('id'=>'create-employee')) }}
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
                                <select>
                                    <option value="" disabled="" selected="">Select client</option>
                                    <option value="">Lorem Ipsum</option>
                                    <option value="">Dolor Sit Amet</option>
                                </select>
                                <!-- <input type="text" name="nama" class="form-control" /> -->
                            </div>
                            <div class="form-group">
                                <label>Report Type</label><br>
                                <select>
                                    <option value="">Contacts and Consults Overview</option>
                                    <option value="">Lorem Ipsum</option>
                                    <option value="">Dolor Sit Amet</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-container">
                        <div class="table-title">Example: Contacts and Consults Overview</div>
                        <table class="table table-striped">
                            <tbody><tr>
                                <td>Table Contacts:</td>
                                <td>x</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Table Consults:</td>
                                <td>x</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Consults Type:</td>
                                <td>Total of Type</td>
                                <td>% of all Consults</td>
                            </tr>
                            <tr>
                                <td>Proactive:</td>
                                <td>x</td>
                                <td>x%</td>
                            </tr>
                            <tr>
                                <td>Health:</td>
                                <td>x</td>
                                <td>x%</td>
                            </tr>
                            <tr>
                                <td>Injury:</td>
                                <td>x</td>
                                <td>x%</td>
                            </tr>
                            <tr>
                                <td>Opportunity:</td>
                                <td>x</td>
                                <td>x%</td>
                            </tr>
                        </tbody></table>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-section">
            <div class="row">
                <div class="col-sm-4">
                    <h3>Options</h3>
                </div>
                <div class="col-sm-8">
                    <input type="checkbox" name="filter-date" value="true"><span class="checkbox-label">Filter by Date Range</span>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group birthdate">
                                <label>Start Date</label><br>
                                <select>
                                    <option value="" selected="">2014</option>
                                    <option value="">2015</option>
                                    <option value="">2016</option>
                                </select>
                                <select>
                                    <option value="" selected="">December</option>
                                    <option value="">January</option>
                                    <option value="">February</option>
                                </select>
                                <select>
                                    <option value="" selected="">15</option>
                                    <option value="">16</option>
                                    <option value="">17</option>
                                </select>   
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group birthdate">
                                <label>End Date</label><br>
                                <select>
                                    <option value="" selected="">2014</option>
                                    <option value="">2015</option>
                                    <option value="">2016</option>
                                </select>
                                <select>
                                    <option value="" selected="">December</option>
                                    <option value="">January</option>
                                    <option value="">February</option>
                                </select>
                                <select>
                                    <option value="" selected="">15</option>
                                    <option value="">16</option>
                                    <option value="">17</option>
                                </select>   
                            </div>  
                        </div>
                    </div>
                    <input type="checkbox" name="specify-location" value="true"><span class="checkbox-label">Specify Locations</span>
                </div>
            </div>
        </div>
        <div class="submit-section">
            <a class="btn btn-submit right" href="{{ URL::route('reports.export') }}">Generate Report</a>
            <button type="button" class="btn btn-cancel right">Cancel</button>
            <div class="clear"></div>
        </div>
    {{ Form::close() }}
@stop
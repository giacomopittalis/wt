@extends('layouts.main')

@section('page-title')
    Data Graph
@stop

@section('content')
    <div class="form-section">
        <div class="row">
            <div class="col-sm-4">
                <h3>Company Trends Graphs</h3>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Date Range</label><br>
                    <input type="text" name="date-range" id="datepicker" class="form-control calendar-input">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8 col-sm-offset-4">
                <div class="graph-container">
                    <canvas id="canvas" height="300" width="650" style="width: 650px; height: 300px;"></canvas>
                    <ul class="graph-labels">
                        <li class="graph-label"></li>
                        <li class="graph-label"></li>
                        <li class="graph-label"></li>
                        <li class="graph-label"></li>
                        <li class="graph-label"></li>
                        <li class="graph-label"></li>
                    </ul>
                </div>                                        
            </div>
        </div>
    </div>
@stop
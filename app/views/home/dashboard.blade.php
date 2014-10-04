@extends('layouts.main')

@section('page-title')
    Activity Feed
@stop

@section('content')
    @if($feeds->count() > 0)
    <ul class="activities">
        @foreach($feeds as $f)
        <li class="activity {{ $f->ftype }}">
            <div class="description"><span class="user">{{ $f->first_name.' '. $f->last_name }}</span> {{ $f->fcomment }}</div>
            <div class="date right">{{ AppHelper::getDateFormatted($f->created_at) }}</div>
        </li>
        @endforeach
    </ul>
    <div class="load-more">
        <input name="page" id="page" type="hidden" value="1">
        <a href="javascript:void(0)" id="load-more">Load more activity</a>
    </div>
    @else
         <div class="load-more">
            No Activity Found
        </div>
    @endif
@stop
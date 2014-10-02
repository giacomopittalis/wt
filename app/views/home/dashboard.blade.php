@extends('layouts.main')

@section('page-title')
    Activity Feed
@stop

@section('content')
    @if($feeds->count() > 0)
    <ul class="activities">
        @foreach($feeds as $f)
        <li class="activity added">
            <div class="description"><span class="user">{{ $f->first_name.' '. $f->last_name }}</span> {{ $f->fcomment }}</div>
            <div class="date right">{{ AppHelper::getDateFormatted($f->created_at) }}</div>
        </li>
        @endforeach
        <li class="activity edited">
            <div class="description"><span class="user">Peyton Sandoz</span> edited the health consult number #4812</div>
            <div class="date right">Today at 5:55PM</div>
        </li>
        <li class="activity added">
            <div class="description"><span class="user">Peyton Sandoz</span> created a new contact</div>
            <div class="date right">Today at 5:55PM</div>
        </li>
        <li class="activity deleted">
            <div class="description"><span class="user">Peyton Sandoz</span> deleted a contact</div>
            <div class="date right">Today at 5:55PM</div>
        </li>
        <li class="activity added">
            <div class="description"><span class="user">Peyton Sandoz</span> created a new employee</div>
            <div class="date right">Today at 5:55PM</div>
        </li>
        <li class="activity edited">
            <div class="description"><span class="user">Peyton Sandoz</span> edited the health consult number #4812</div>
            <div class="date right">Today at 5:55PM</div>
        </li>
        <li class="activity added">
            <div class="description"><span class="user">Peyton Sandoz</span> created a new contact</div>
            <div class="date right">Today at 5:55PM</div>
        </li>
        <li class="activity deleted">
            <div class="description"><span class="user">Peyton Sandoz</span> deleted a contact</div>
            <div class="date right">Today at 5:55PM</div>
        </li>
    </ul>
    @endif
    <div class="load-more">Load more activity</div>
@stop
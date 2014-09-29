@extends('layouts.main')

@section('page-title')
    Activity Feed
@stop

@section('content')
    <ul class="activities">
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
    <div class="load-more">Load more activity</div>
@stop
@extends('layouts.app')
@section('content')
<transition name="fade"><router-view v-bind:key="$route.fullPath"></router-view></transition>
@endsection

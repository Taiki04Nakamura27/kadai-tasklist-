@extends('layouts.app')

@section('content')
    @include('tasks.index', ['tasks' => $tasks])
@endsection
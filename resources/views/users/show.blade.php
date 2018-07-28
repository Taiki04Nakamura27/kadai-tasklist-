@extends('layouts.app')

@section('content')
    @include('tasks.show', ['tasks' => $tasks])
@endsection
@extends('layouts.app')

@section('content')

<h1>タスク新規作成ページ</h1>

    {!! Form::model($task, ['route' => 'tasks.store']) !!}

        {!! Form::label('content', 'タスク名:') !!}
        {!! Form::text('content') !!}

        {!! Form::submit('保存') !!}

    {!! Form::close() !!}

@endsection
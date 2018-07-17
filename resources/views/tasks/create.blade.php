@extends('layouts.app')

@section('content')

<h1>タスク新規作成ページ</h1>

    {!! Form::model($task, ['route' => 'tasks.store']) !!}

        {!! Form::label('status', '進捗状況:') !!}
        {!! Form::text('status') !!}

        {!! Form::label('content', 'タスク内容:') !!}
        {!! Form::text('content') !!}

        {!! Form::submit('保存') !!}

    {!! Form::close() !!}

@endsection
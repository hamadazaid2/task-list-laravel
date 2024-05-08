@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    @include('tasks.form', ['task' => $task])
@endsection

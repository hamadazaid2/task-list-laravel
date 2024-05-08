@extends('layouts.app')

@section('title', isset($task) ? 'Edit Task' : 'Add Task')

@section('style')
    <style>
        .error {
            color: red;
            font-size: 0.8 rem
        }
    </style>
@endsection

@section('content')
    <form action="{{ isset($task) ? route('tasks.update', ['id' => $task->id]) : route('tasks.store') }}" method="POST">
        @csrf
        @isset($task)
            @method('PUT')
        @endisset
        <div class="mb-4">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="{{ $task->title ?? old('title') }}"
                @class(['border-red-500' => $errors->has('title')]) class='@error('title') border-red-500 @enderror border'>
            @error('title')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="description">Description</label>
            <textarea type="text" id="description" name="description" rows="5" @class(['border-red-500' => $errors->has('description')])>{{ $task->description ?? old('description') }}</textarea>
            @error('description')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="long_description">Long Description</label>
            <textarea type="text" id="long_description" name='long_description' rows="10" @class(['border-red-500' => $errors->has('long_description')])>{{ $task->long_description ?? old('long_description') }}</textarea>
            @error('long_description')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex gap-2">
            <button type="submit" class="btn">
                @isset($task)
                    Edit Task
                @else
                    Add Task
                @endisset
            </button>
            <a href="{{ route('tasks.index') }}" class="link">Cancel</a>
        </div>
    </form>
@endsection

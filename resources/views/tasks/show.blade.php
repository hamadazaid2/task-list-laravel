@extends('layouts.app')

@section('title', $task->title)

@section('content')
    <div>
        <a href="{{ route('tasks.index') }}" class="font-medium text-gray-700 underline decoration-pink-500">👈 Go Back to the
            task list</a>
    </div>
    <p class="mb-4 text-slate-700">{{ $task->description }}</p>

    @if ($task->long_description)
        <p class="mb-4 text-slate-700">{{ $task->long_description }}</p>
    @endif
    <p class="mb-4">
        @if ($task->completed)
            <span class="font-medium text-green-500">Completed</span>
        @else
            <span class="font-medium text-red-500">Not Completed</span>
        @endif
    </p>
    <p class="mb-4 text-sm text-slate-500">Created {{ $task->created_at->diffForHumans() }} . Updated
        {{ $task->updated_at->diffForHumans() }}</p>
    <p></p>

    <div class="flex gap-2">
        <a href="{{ route('tasks.edit', ['id' => $task->id]) }}" class="btn">Edit</a>

        <form action="{{ route('tasks.destroy', ['id' => $task->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn">Delete Task</button>
        </form>

        <form action="{{ route('tasks.toggle-complete', ['task' => $task->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="btn">Mark as {{ $task->completed ? 'Not Completed' : 'Completed' }}</button>
        </form>
    </div>
@endsection

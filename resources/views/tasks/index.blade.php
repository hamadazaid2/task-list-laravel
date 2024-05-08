@extends('layouts.app')

@section('title', 'The list of the tasks')

@section('content')
    <h1>
        Task List
    </h1>

    <div>
        <a href="{{ route('tasks.create') }}" class="link">Add Task</a>
    </div>

    @forelse ($tasks as $task)
        <a href="{{ route('tasks.show', ['id' => $task->id]) }}" @class(['font-bold', 'line-through' => $task->completed])>{{ $task->title }}!</li> <br>
        @empty
            <div>There is no tasks</div>
    @endforelse

    @if ($tasks->count())
        <nav class="mt-4">
            {{ $tasks->links() }}
        </nav>
    @endif
@endsection

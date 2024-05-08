<?php

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// class Task
// {
//     public function __construct(
//         public int $id,
//         public string $title,
//         public string $description,
//         public ?string $long_description,
//         public bool $completed,
//         public string $created_at,
//         public string $updated_at
//     ) {
//     }
// }

// $tasks = [
//     new Task(
//         1,
//         'Buy groceries',
//         'Task 1 description',
//         'Task 1 long description',
//         false,
//         '2023-03-01 12:00:00',
//         '2023-03-01 12:00:00'
//     ),
//     new Task(
//         2,
//         'Sell old stuff',
//         'Task 2 description',
//         null,
//         false,
//         '2023-03-02 12:00:00',
//         '2023-03-02 12:00:00'
//     ),
//     new Task(
//         3,
//         'Learn programming',
//         'Task 3 description',
//         'Task 3 long description',
//         true,
//         '2023-03-03 12:00:00',
//         '2023-03-03 12:00:00'
//     ),
//     new Task(
//         4,
//         'Take dogs for a walk',
//         'Task 4 description',
//         null,
//         false,
//         '2023-03-04 12:00:00',
//         '2023-03-04 12:00:00'
//     ),
// ];


// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/tasks', function () use ($tasks) {
//     return view('tasks.index', [
//         'tasks' => $tasks
//     ]);
// })->name(('tasks.index'));

// Route::get('tasks/{id}', function ($id) use ($tasks) {
//     // collect function create a collection instance from an array or an iterable object.
//     $task = collect($tasks)->firstWhere('id', $id);

//     if (!$task)
//         abort(Response::HTTP_NOT_FOUND);

//     return view('tasks.show', ['task' => $task]);
// })->name('tasks.show');

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::get('tasks', function () {
    // return view('tasks.index', ['tasks' => Task::latest()->get()]);
    return view('tasks.index', ['tasks' => Task::latest()->paginate()]);
})->name('tasks.index');

Route::view('/tasks/create', 'tasks.create')->name('tasks.create');

Route::get('tasks/{id}', function ($id) {
    return view('tasks.show', ['task' => App\Models\Task::findOrFail($id)]);
})->name('tasks.show');

Route::post('tasks', function (TaskRequest $request) {
    $data = $request->validated();
    // if any of validation rules violated, the error will return to blade in $erros array in user session

    // $task = new Task();
    // $task->title = $data['title'];
    // $task->description = $data['description'];
    // $task->long_description = $data['long_description'];

    // $task->save();

    $task = Task::create($data);

    return redirect()->route('tasks.show', ['id' => $task->id])->with('success', 'Task created successfully!');
    // with function sends a key value to with the session to the blade, so in blade i can do that @if(session()->has('sucess')) {{ session('message') }}

})->name('tasks.store');

Route::get('tasks/{id}/edit', function ($id) {
    // fetch the task 
    $task = Task::findOrFail($id);

    return view('tasks.edit', ['task' => $task]);
})->name('tasks.edit');

Route::put('tasks/{id}', function (TaskRequest $request, $id) {
    // fetch the task 
    $task = Task::findOrFail($id);

    // validate the data 
    $data = $request->validated();

    // $task->title = $request['title'];
    // $task->description = $request['description'];
    // $task->long_description = $request['long_description'];
    // $task->save();

    $task->update($data);

    return redirect()->route('tasks.show', ['id' => $task->id])
        ->with('success', 'Task Updated Sunccessfully!');


})->name('tasks.update');

Route::delete('tasks/{id}', function ($id) {
    // fetch the task 
    $task = Task::findOrFail($id);

    // delete the task 
    $task->delete();

    // redirect to view
    return redirect()->route('tasks.index')->
        with('success', 'Task deleted successfully!');
})->name('tasks.destroy');

Route::put('tasks/{task}/toggle-complete', function (Task $task) {
    $task->toggleComplete();

    return redirect()->back()->with('success', 'Task Updated Successfully');
})->name('tasks.toggle-complete');

// There is something called model binding, that when we send id in the parameter then we fetch the task using findOrFail
// Instead we can bind it like thatRoute::get('tasks/{task}', function(Task $task)) now by this we send the id in {task}
// and automatically it goes to the model and fetch the record and return it, if the record not found it will return 404
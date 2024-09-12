<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Crear tarea
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:500',
            'email' => 'required|max:500',
        ]);

        $task = new Task($validated);
        $user = User::where('email',$validated['email'])->first();
        $task->user_id = $user->id;
        $task->save();

        $createdTask = $this->find($task->id);

        return response()->json(['success' => 'Task created successfully.', 'task' => $createdTask]);
    }

    // Actualizar tarea
    public function update($id)
    {

        $task = Task::find($id);

        if(!$task) {
            return response()->json(['error' => 'Task not found.']);
        }

        $task->completed = !$task->completed;

        $task->save();

        $updatedTask = $this->find($task->id);

        return response()->json(['success' => 'Task updated successfully.', 'task' => $updatedTask]);
    }

    // Eliminar tarea
    public function destroy($id)
    {
        $task = Task::find($id);

        if(!$task) {
            return response()->json(['error' => 'Task not found.']);
        }

        $task->delete();

        return response()->json(['success' => 'Task deleted successfully.']);
    }

    // Obtener tareas
    public function fetch()
    {
        $tasks = Task::with('user:id,name,email')->orderBy('created_at', 'desc')->limit(3)->get();
        return $tasks;
    }

    // Obtener una tarea
    public function find($id)
    {
        $task = Task::with('user:id,name,email')->findOrFail($id);
        return $task;
    }
}

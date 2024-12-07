<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return auth()->user()->tasks()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $task = auth()->user()->tasks()->create($validated);

        return response()->json($task, 201);
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task->delete();

        return response()->json(null, 204);
    }

    public function update(Request $request, Task $task)
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validate the incoming request
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'status' => 'sometimes|string|in:pending,completed', // Allow lowercase values
        ]);

        // Update the task fields if provided
        if ($request->has('title')) {
            $task->title = $validated['title'];
        }

        if ($request->has('status')) {
            $task->status = $validated['status'];
        }

        // Save the updated task
        $task->save();

        // Return the updated task as a JSON response
        return response()->json($task);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Http\Resources\TaskResource;
use App\Policies\TaskPolicy;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->has('title')) {
            $query->where('title', 'like', "%{$request->title}%");
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $this->authorize('viewAny', Task::class);
        $tasks = $query->latest()->paginate(10);

        return response()->json([
            'data' => TaskResource::collection($tasks)
        ], 200);
    }

    public function store(StoreTaskRequest $request)
    {
        $this->authorize('create', Task::class);
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'user_id' => $request->user()->id
        ]);

        return response()->json([
            'message' => 'created',
            'data' => TaskResource::make($task)
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('view', $task);
        return response()->json([
            'data' => TaskResource::make($task)
        ], 200);
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('update', $task);
        $task->update($request->validated());

        return response()->json([
            'message' => 'updated',
            'data' => TaskResource::make($task)
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('delete', $task);
        $task->delete();
        return response()->json([
            'message' => 'deleted',
            'data' => TaskResource::make($task)
        ], 200);
    }
}

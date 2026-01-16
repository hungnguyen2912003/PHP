<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->has('title')) {
            $query->where('title', 'like', "%{$request->title}%");
        }

        if ($request->has('status')) {
            $query->where('status', 'like', "%{$request->status}%");
        }

        $tasks = $query->paginate(10)->withQueryString();

        return response()->json([
            'data' => TaskResource::collection($tasks)
        ], 200);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'created',
            'data' => TaskResource::make($task)
        ], 201);
    }

    public function show($id)
    {
        $task = Task::findOrFail($id);
        return response()->json([
            'data' => TaskResource::make($task)
        ], 200);
    }

    public function update(StoreTaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'updated',
            'data' => TaskResource::make($task)
        ], 200);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json([
            'message' => 'deleted',
            'data' => TaskResource::make($task)
        ], 200);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;

class TaskController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => [
                [
                    'id' => 1,
                    'title' => 'Task 1',
                    'description' => 'Description 1',
                    'status' => 'pending'
                ],
                [
                    'id' => 2,
                    'title' => 'Task 2',
                    'description' => 'Description 2',
                    'status' => 'completed'
                ]
            ]
        ]);
    }

    public function store(StoreTaskRequest $request)
    {
        $title = $request->input('title');

        return response()->json([
            'message' => 'created',
            'data' => [
                'id' => 3,
                'title' => $title,
                'description' => 'Description 3',
                'status' => 'pending'
            ]
        ], 201);
    }

    public function show($id)
    {
        return response()->json([
            'data' => [
                'id' => $id,
                'title' => 'Task 1',
                'description' => 'Description 1',
                'status' => 'pending'
            ]
        ]);
    }
}

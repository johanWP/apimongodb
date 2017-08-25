<?php

namespace App\Http\Controllers;

use App\Task;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::paginate(5);
        return $tasks;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TaskStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskStoreRequest $request)
    {

        $task = new Task;
        if ($task->create($request->all())) {
            $responseMsg = "OK";
            $responseCode = 200;
        } else {
            $responseMsg = "something went wrong";
            $responseCode = 400;
        }

        return response($responseMsg, $responseCode);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        return json_encode($task);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TaskUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskUpdateRequest $request, $id)
    {

        $task = Task::findOrFail($id);
        $responseCode = 400;

        try {
            if ($task->update($request->all())) {
                $responseMsg = "OK";
                $responseCode = 200;
            } else {
                $responseMsg = "something went wrong";
            }
        }
        catch (\Exception $e) {
            $responseMsg = $e->getMessage();
        }
        return response($responseMsg, $responseCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $responseCode = 400;

        try {
            if ($task->delete()) {
                $responseMsg = "OK";
                $responseCode = 200;
            } else {
                $responseMsg = "something went wrong";
            }
        }
        catch (\Exception $e) {
            $responseMsg = $e->getMessage();
        }

        return response($responseMsg, $responseCode);
    }
}

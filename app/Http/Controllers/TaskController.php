<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
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
        $minutes = 5;
        $tasks = Cache::remember('task', $minutes, function () {
            return Task::paginate(5);;
        });
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
        $task->title = $request->title;
        $task->description = $request->description;
        $task->completed = $request->completed;
        $task->due_date = $request->due_date;

        if ($task->save()) {
            $responseMsg = "OK";
            $responseCode = 200;
        } else {
            $responseMsg = "something went wrong";
            $responseCode = 400;
        }
        return response(json_encode(["result" => $responseMsg, "id" => $task->id]), $responseCode);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        $minutes = 5;
//        $task = Cache::remember('task', $minutes, function () use ($id) {
//            return Task::findOrFail($id);
//        });
//
//        return json_encode($task);
        return Task::findOrFail($id);
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
        return response(json_encode(["result" => $responseMsg]), $responseCode);
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

        return response(json_encode(["result" => $responseMsg]), $responseCode);
    }

    public function filter(\Illuminate\Http\Request $request)
    {
        $this->validate($request, [
            'completed'     => 'boolean',
            'due_date'      => 'date',
            'created_at'    => 'date',
            'updated_at'    => 'date',
        ]);

        $completed = Input::get('completed');
        $dueDate = Input::get('due_date');
        $createdAt = Input::get('created_at');
        $updatedAt = Input::get('updated_at');

        return json_encode(
            Task::filterCompleted($completed)->
                filterByDateField('due_date', $dueDate)->
                filterByDateField('created_at', $createdAt)->
                filterByDateField('updated_at', $updatedAt)->
                orderBy('due_date')->
                paginate(5)
        );
    }
}

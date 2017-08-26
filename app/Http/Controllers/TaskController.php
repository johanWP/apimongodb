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

    public function filter(\Illuminate\Http\Request $request)
    {
        $tasks = collect();

        $this->validate($request, [
            'completed'     => 'boolean',
            'due_date'      => 'date',
            'created_at'    => 'date',
            'updated_at'    => 'date',
        ]);


        if (Input::get('completed')) {
            $order = (strtolower(Input::get('order')) == 'asc') ? Input::get('order') : 'desc';
            $tasks = Task::where('completed', Input::get('completed'))->orderBy('due_date', $order)->get();
        }

        if (Input::get('due_date')) {
            $tasks = $this->filterByDateField('due_date');
        }

        if (Input::get('created_at')) {
            $tasks = $this->filterByDateField('created_at');
        }

        if (Input::get('updated_at')) {
            $tasks = $this->filterByDateField('updated_at');
        }
        return $tasks;
    }

    private function filterByDateField($dateFieldName)
    {
        $value = Input::get($dateFieldName);
        $sort = (strtolower(Input::get('order')) == 'asc') ? 'asc' : 'desc';
        $operator = (strtolower(Input::get('order')) == 'asc') ? '>' : '<';
        $d = new \DateTime($value);
        $tasks = Task::where($dateFieldName, $operator, $d)->orderBy($dateFieldName, $sort)->get();

        return $tasks;
    }
}

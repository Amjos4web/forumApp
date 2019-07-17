<?php

namespace myLaravelFirstApp\Http\Controllers;

use Illuminate\Http\Request;
use myLaravelFirstApp\Task;
//use myLaravelFirstApp\User;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    // block unauthorized access to create page
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user_id = auth()->user()->id;
        $tasks = Task::where('user_id', $user_id)->orderBy('is_complete', 'asc')->paginate(3);
        return view('tasks.index')->with('tasks', $tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:20',
            'description' => 'required|max:200'
        ]);

        $task = new Task();
        $task->user_id = auth()->user()->id;
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->is_complete = false;
        $task->save();

        return redirect('/tasks')->with('success', 'Task Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        return view('tasks.show')->with('tasks', $task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);

        // check for correct user
        if (auth()->user()->id !== $task->user_id){
            return redirect('/task')->with('error', 'Unauthorized Page');
        }

        return view('tasks.edit')->with('tasks', $task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:20',
            'description' => 'required|max:200',
        ]);

        $task = Task::find($id);
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->is_complete = true;
        $task->save();

        return redirect('/tasks')->with('success', 'Task Completed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        // check for correct user
        if (auth()->user()->id !== $task->user_id){
            return redirect('/dashboard')->with('error', 'Unauthorized Page');
        }

        $task->delete();

        return redirect('/dashboard')->with('success', 'Task Deleted');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
            $data += $this->counts($user);
            return view('tasks.index', $data);
        }else {
            return view('welcome');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
        @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $task = new Task;

        return view('tasks.create', [
            'task' => $task,
        ]);
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
            'status' => 'required|max:10',
            'content' => 'required|max:191',
        ]);
        
        $request->user()->tasks()->create([
            'content' => $request->content,
            'status' => $request->status,
        ]);

        return redirect('/tasks/');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // id をもとにMicropostを取得
        $task = \App\Task::find($id);

        // 自分（ログインユーザー）のidとMicropostのuser_idが一致する場合のみ詳細を表示。
        if (\Auth::id() === $task->user_id) {
        
                return view('tasks.show', [
                    'task' => $task,
                ]);
                
        }
        else{
            return redirect('/');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
    $task = \App\Task::find($id);

        if (\Auth::id() === $task->user_id) {
            
       $task = Task::find($id);

        return view('tasks.edit', [
            'task' => $task,
        ]);
    }
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
        $task = \App\Task::find($id);

        if (\Auth::id() === $task->user_id) {
        $this->validate($request, [
            'content' => 'required|max:191',
        ]);
        
        $task = Task::find($id);
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        }
        
        return redirect('/tasks/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // id をもとにMicropostを取得
        $task = \App\Task::find($id);

        // 自分（ログインユーザー）のidとMicropostのuser_idが一致する場合のみ削除
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }

        // 元のページにリダイレクト
        return redirect('/tasks/');
    }
}

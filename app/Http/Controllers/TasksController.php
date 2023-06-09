<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TasksController extends Controller
{
    public function store(Request $request){
        $rules=[
            'todo' =>'required|unique:tasks'
        ];
        $data=request()->all();
        $valid=Validator::make($data,$rules);
        if(count($valid->errors())){
            return response()->json([
               'message' =>'failed',
                'data' => $valid->errors()
            ],404);
        }
        $todo_id=$request->todo_id;

        if($todo_id >=!0 ){

            $task = new Task();

            $user_id= auth::user()->id;

            $currentDate = Carbon::now()->format('j, n, Y');
            $currentTime = Carbon::now()->format('H:i');
            $task->todo = $request->todo;
            $task->date = $currentDate;
            $task->time = $currentTime;
            $task->user_id = $user_id;
            $task->save();

            return response()->json([
                'status' =>'success',
                'message' =>'task added successfully',
                'data' => $task,
            ]);

        }

      
    }
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'todo' => 'required|max:255',
            'user_id' => 'required|integer',
        ]);

        $task = Task::find($id);

        $task->todo = $data['todo'];
        $task->user_id = $data['user_id'];

        $task->save();

    return response()->json([
          'message' =>"updated successfully",
            'data' => $task
        ]);
    }
    public function destroy(Request $request, $id){
        $task = Task::find($id);
        $task->delete();
        return response()->json([
           'message' =>"deleted successfully",
            'data' => $task
        ]);
    }
    public function show(Request $request){
        $user=Auth::user();
        $user_id=$user->id;
        $tasks=Task::where('user_id',$user_id)->get();

        return response()->json($tasks);
    }
    public function edit(Request $request,$id){
        $task=Task::where('id',$id)->first();
        return response()->json($task);
    }
    public function updateone(Request $request, $id) {
        $task = Task::where('id',$id)->get()->first(); // Find the task with the given ID
        $todo=$request->etodo;
        $task->todo =$todo;
        $task->save();
        return response()->json([
            'message' =>"updated successfully",
            'data' => $task
        ]);
    }

    public function get_reviews(Request $request){
        $user=auth::user();
        $user_id=$user->id;
        $reviews=Review::where('user_id',$user_id)->get();
        return response()->json($reviews);
    }
    public function mark_completed(Request $request, $id){

        $task=Task::find($id);

        $task->status='inactive';
        $task->update();
        return response()->json(
            [
                'status' =>'Task completed successfully',
                'data' =>$task
            ]
        );
    }

}

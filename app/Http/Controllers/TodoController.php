<?php
namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
  public function create(Request $request)
  {
    $this->validate($request, [
      'task'      => 'required',
      'completed' => 'required|boolean',
    ]);

    $user_id = $request->header('id');

    $todo = Todo::create([
      'task'      => $request->task,
      'completed' => $request->completed,
      'user_id'   => $user_id,
    ]);

    return response()->json(['message' => 'Todo created successfully', 'todo' => $todo], 201);
  }

  public function read()
  {
    $user_id = $request->header('id');
    $todos   = Todo::where('user_id', $user_id)->get();
    return response()->json(['todos' => $todos], 200);
  }

  public function update(Request $request, $id)
  {
    $this->validate($request, [
      'task'      => 'required',
      'completed' => 'required|boolean',
    ]);

    $todo = Todo::find($id);

    $todo->update([
      'task'      => $request->task,
      'completed' => $request->completed,
    ]);

    return response()->json(['message' => 'Todo updated successfully', 'todo' => $todo], 200);
  }

  public function delete($id)
  {
    $todo = Todo::find($id);

    if (!$todo) {
      return response()->json(['message' => 'Todo not found'], 404);
    }
    $todo->delete();
    return response()->json(['message' => 'Todo deleted successfully'], 200);
  }
}

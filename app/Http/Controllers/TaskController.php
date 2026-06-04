<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Tag;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with('tags');
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('priority') && $request->priority != '') {
            $query->where('priority', $request->priority);
        }
        
        if ($request->has('tag_id') && $request->tag_id != '') {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('tags.id', $request->tag_id);
            });
        }
        
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        $tasks = $query->orderBy('created_at', 'desc')->paginate(10);
        $tags = Tag::all();
        
        return view('tasks.index', compact('tasks', 'tags'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('tasks.create', compact('tags'));
    }

    public function store(TaskRequest $request)
    {
        $task = Task::create($request->validated());
        
        if ($request->has('tags')) {
            $task->tags()->attach($request->tags);
        }
        
        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    public function show(Task $task)
    {
        $task->load('tags');
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $tags = Tag::all();
        $task->load('tags');
        return view('tasks.edit', compact('task', 'tags'));
    }

    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        $task->tags()->sync($request->tags ?? []);
        
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        Task::whereIn('id', $request->ids)->delete();
        
        return response()->json(['success' => 'Selected tasks deleted successfully!']);
    }

    public function toggleStatus(Task $task)
    {
        $task->status = $task->status === 'completed' ? 'pending' : 'completed';
        $task->save();
        
        return redirect()->back()->with('success', 'Task status updated!');
    }
}
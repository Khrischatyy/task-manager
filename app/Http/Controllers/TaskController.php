<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $projectId = $request->query('project_id');
        $projects = Project::all();

        $query = Task::query()->orderBy('priority', 'asc');

        if ($projectId) {
            $query->where('project_id', $projectId);
        }

        $tasks = $query->get();

        return view('tasks.index', compact('tasks', 'projects', 'projectId'));
    }

    public function create()
    {
        $projects = Project::all();
        return view('tasks.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        // Get the highest priority and add 1
        $maxPriority = Task::max('priority') ?? 0;

        Task::create([
            'name' => $request->name,
            'priority' => $maxPriority + 1,
            'project_id' => $request->project_id,
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        $projects = Project::all();
        return view('tasks.edit', compact('task', 'projects'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $task->update([
            'name' => $request->name,
            'project_id' => $request->project_id,
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        // Reorder priorities
        $tasks = Task::orderBy('priority')->get();
        foreach ($tasks as $index => $t) {
            $t->priority = $index + 1;
            $t->save();
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

    public function updateOrder(Request $request)
    {
        $tasks = $request->input('tasks', []);

        foreach ($tasks as $index => $taskId) {
            Task::where('id', $taskId)->update(['priority' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}

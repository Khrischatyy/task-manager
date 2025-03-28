@extends('layouts.app')

@section('content')
    <div class="row mb-3">
        <div class="col">
            <h1>Tasks</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Task
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Filter by Project</div>
        <div class="card-body">
            <form action="{{ route('tasks.index') }}" method="GET" class="row g-3">
                <div class="col-md-6">
                    <select name="project_id" class="form-select">
                        <option value="">All Projects</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ $projectId == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    @if($projectId)
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Clear</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Task List (drag to reorder)</h5>
        </div>
        <div class="card-body">
            <div class="task-list" id="taskList">
                @if(count($tasks) > 0)
                    @foreach($tasks as $task)
                        <div class="task-item d-flex justify-content-between align-items-center" data-id="{{ $task->id }}">
                            <div>
                                <strong>{{ $task->name }}</strong>
                                @if($task->project)
                                    <span class="badge bg-info ms-2">{{ $task->project->name }}</span>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-info mb-0">No tasks found.</div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const taskList = document.getElementById('taskList');
            if (taskList) {
                new Sortable(taskList, {
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    onEnd: function() {
                        const taskIds = Array.from(taskList.querySelectorAll('.task-item')).map(item => item.dataset.id);

                        fetch('{{ route('tasks.update-order') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ tasks: taskIds })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    console.log('Order updated successfully');
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    }
                });
            }
        });
    </script>
@endsection

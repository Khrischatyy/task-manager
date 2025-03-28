@extends('layouts.app')

@section('content')
    <div class="row mb-3">
        <div class="col">
            <h1>Projects</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('projects.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Project
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if(count($projects) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Tasks</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($projects as $project)
                            <tr>
                                <td>{{ $project->id }}</td>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->tasks->count() }}</td>
                                <td>
                                    <a href="{{ route('tasks.index', ['project_id' => $project->id]) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-tasks"></i> View Tasks
                                    </a>
                                    <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure? This will delete all associated tasks.')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">No projects found.</div>
            @endif
        </div>
    </div>
@endsection

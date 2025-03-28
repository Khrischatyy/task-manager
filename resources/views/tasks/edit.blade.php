@extends('layouts.app')

@section('content')
    <div class="row mb-3">
        <div class="col">
            <h1>Edit Task</h1>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Task Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $task->name) }}" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="project_id" class="form-label">Project (Optional)</label>
                    <select class="form-select @error('project_id') is-invalid @enderror" id="project_id" name="project_id">
                        <option value="">No Project</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('project_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Task</button>
                </div>
            </form>
        </div>
    </div>
@endsection

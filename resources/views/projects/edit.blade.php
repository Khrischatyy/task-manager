@extends('layouts.app')

@section('content')
    <div class="row mb-3">
        <div class="col">
            <h1>Edit Project</h1>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('projects.update', $project) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Project Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $project->name) }}" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Project</button>
                </div>
            </form>
        </div>
    </div>
@endsection

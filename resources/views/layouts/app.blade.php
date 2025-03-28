<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .task-list {
            min-height: 100px;
            border: 1px dashed #ccc;
            padding: 10px;
            border-radius: 5px;
        }
        .task-item {
            cursor: move;
            margin-bottom: 10px;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 3px;
            border-left: 3px solid #007bff;
        }
        .sortable-ghost {
            opacity: 0.4;
            background: #c8ebfb;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('tasks.index') }}">Task Manager</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tasks.index') }}">Tasks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('projects.index') }}">Projects</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>

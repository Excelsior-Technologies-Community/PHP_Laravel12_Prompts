@extends('layouts.app')

@section('title', 'Task Manager')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="header">
        <h1>Task Manager</h1>
        <a href="{{ route('tasks.create') }}" class="btn-new">New Task</a>
    </div>

    <!-- Search Box -->
    <div class="search-box">
        <form method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search tasks..." value="{{ request('search') }}" class="search-input">
            <select name="status" class="filter-select">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            <select name="priority" class="filter-select">
                <option value="">All Priority</option>
                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
            </select>
            <button type="submit" class="btn-filter">Filter</button>
            <a href="{{ route('tasks.index') }}" class="btn-reset">Reset</a>
        </form>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="success-msg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tasks Grid -->
    <div class="tasks-grid">
        @forelse($tasks as $task)
            <div class="task-card">
                <!-- Task Title -->
                <div class="task-title">
                    @if($task->is_featured)
                        <span class="star"></span>
                    @endif
                    <h3>{{ $task->title }}</h3>
                </div>

                <!-- Description -->
                <div class="task-desc">
                    {{ Str::limit($task->description ?? 'No description', 100) }}
                </div>

                <!-- Priority Badge -->
                <div class="task-priority">
                    <span class="priority-badge priority-{{ $task->priority }}">
                        {{ ucfirst($task->priority) }}
                    </span>
                </div>

                <!-- Status Badge -->
                <div class="task-status">
                    <span class="status-badge status-{{ $task->status }}">
                        @if($task->status == 'pending') Pending
                        @elseif($task->status == 'in_progress') In Progress
                        @else Completed
                        @endif
                    </span>
                </div>

                <!-- Due Date -->
                @if($task->due_date)
                    <div class="task-date">
                        Due: {{ $task->due_date->format('M d, Y') }}
                    </div>
                @endif

                <!-- Tags -->
                @if($task->tags->count() > 0)
                    <div class="task-tags">
                        @foreach($task->tags as $tag)
                            <span class="tag" style="background: {{ $tag->color }}20; color: {{ $tag->color }};">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif

                <!-- Action Buttons - Simple Colors -->
                <div class="task-actions">
                    <a href="{{ route('tasks.show', $task) }}" class="btn-view">View</a>
                    <a href="{{ route('tasks.edit', $task) }}" class="btn-edit">Edit</a>
                    <a href="{{ route('tasks.toggle-status', $task) }}" class="btn-complete">
                        {{ $task->status == 'completed' ? 'Reopen' : 'Complete' }}
                    </a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" onclick="return confirm('Delete this task?')">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">📋</div>
                <h3>No tasks found</h3>
                <p>Create your first task to get started</p>
                <a href="{{ route('tasks.create') }}" class="btn-new">Create Task</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pagination">
        {{ $tasks->appends(request()->query())->links() }}
    </div>
</div>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: #f5f5f5;
        padding: 40px 20px;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Header */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        background: white;
        padding: 20px 30px;
        border-radius: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .header h1 {
        color: #333;
        font-size: 24px;
        font-weight: 600;
    }

    .btn-new {
        background: #4CAF50;
        color: white;
        padding: 8px 16px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px;
        border: none;
        cursor: pointer;
    }

    .btn-new:hover {
        background: #45a049;
    }

    /* Search Box */
    .search-box {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 30px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .search-form {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .search-input {
        flex: 2;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    .filter-select {
        flex: 1;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background: white;
    }

    .btn-filter {
        background: #2196F3;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-filter:hover {
        background: #0b7dda;
    }

    .btn-reset {
        background: #9E9E9E;
        color: white;
        padding: 8px 16px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
    }

    .btn-reset:hover {
        background: #757575;
    }

    /* Success Message */
    .success-msg {
        background: #e8f5e9;
        color: #2e7d32;
        padding: 12px 20px;
        border-radius: 5px;
        margin-bottom: 20px;
        border-left: 3px solid #4CAF50;
    }

    /* Tasks Grid */
    .tasks-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    /* Task Card */
    .task-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: box-shadow 0.2s;
    }

    .task-card:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .task-title {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
    }

    .star {
        font-size: 16px;
    }

    .task-title h3 {
        color: #333;
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }

    .task-desc {
        color: #666;
        font-size: 13px;
        line-height: 1.5;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }

    /* Priority Badges - Simple Colors */
    .priority-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .priority-high {
        background: #ffebee;
        color: #c62828;
    }

    .priority-medium {
        background: #fff3e0;
        color: #ef6c00;
    }

    .priority-low {
        background: #e8f5e9;
        color: #2e7d32;
    }

    /* Status Badges - Simple Colors */
    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .status-pending {
        background: #fff9c4;
        color: #f57f17;
    }

    .status-in_progress {
        background: #e3f2fd;
        color: #1565c0;
    }

    .status-completed {
        background: #e8f5e9;
        color: #2e7d32;
    }

    /* Due Date */
    .task-date {
        color: #888;
        font-size: 12px;
        margin-bottom: 10px;
    }

    /* Tags */
    .task-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 15px;
    }

    .tag {
        padding: 3px 8px;
        border-radius: 3px;
        font-size: 11px;
        font-weight: 500;
    }

    /* Action Buttons - Simple & Clean */
    .task-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        padding-top: 12px;
        border-top: 1px solid #eee;
    }

    .btn-view, .btn-edit, .btn-complete, .btn-delete {
        padding: 5px 12px;
        border-radius: 3px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
        border: 1px solid;
        cursor: pointer;
        transition: opacity 0.2s;
        display: inline-block;
        text-align: center;
    }

    .btn-view {
        background: white;
        color: #2196F3;
        border-color: #2196F3;
    }

    .btn-view:hover {
        background: #2196F3;
        color: white;
    }

    .btn-edit {
        background: white;
        color: #FF9800;
        border-color: #FF9800;
    }

    .btn-edit:hover {
        background: #FF9800;
        color: white;
    }

    .btn-complete {
        background: white;
        color: #4CAF50;
        border-color: #4CAF50;
    }

    .btn-complete:hover {
        background: #4CAF50;
        color: white;
    }

    .btn-delete {
        background: white;
        color: #f44336;
        border-color: #f44336;
    }

    .btn-delete:hover {
        background: #f44336;
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 10px;
    }

    .empty-icon {
        font-size: 48px;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        color: #333;
        margin-bottom: 10px;
        font-size: 18px;
    }

    .empty-state p {
        color: #666;
        margin-bottom: 20px;
        font-size: 14px;
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .tasks-grid {
            grid-template-columns: 1fr;
        }
        
        .search-form {
            flex-direction: column;
        }
        
        .header {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
        
        .task-actions {
            flex-direction: column;
        }
        
        .btn-view, .btn-edit, .btn-complete, .btn-delete {
            width: 100%;
        }
    }
</style>
@endsection
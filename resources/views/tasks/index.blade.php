@extends('layouts.app')

@section('title', 'Task Manager')

@section('content')
<div class="container">
    <div class="header">
        <h1>Task Manager</h1>
        <a href="{{ route('tasks.create') }}" class="btn-new">New Task</a>
    </div>

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
            <select name="tag_id" class="filter-select">
                <option value="">All Tags</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" {{ request('tag_id') == $tag->id ? 'selected' : '' }}>{{ $tag->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-filter">Filter</button>
            <a href="{{ route('tasks.index') }}" class="btn-reset">Reset</a>
        </form>
    </div>

    @if(session('success'))
        <div class="success-msg">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-bottom: 20px;">
        <button id="bulk-delete" class="btn-delete">Delete Selected</button>
    </div>

    <div class="tasks-grid">
        @forelse($tasks as $task)
            <div class="task-card">
                <div class="task-title">
                    <input type="checkbox" class="task-checkbox" value="{{ $task->id }}">
                    @if($task->is_featured)
                        <span class="star">⭐</span>
                    @endif
                    <h3>{{ $task->title }}</h3>
                </div>

                <div class="task-desc">
                    {{ Str::limit($task->description ?? 'No description', 100) }}
                </div>

                <div class="task-priority">
                    <span class="priority-badge priority-{{ $task->priority }}">
                        {{ ucfirst($task->priority) }}
                    </span>
                </div>

                <div class="task-status">
                    <span class="status-badge status-{{ $task->status }}">
                        @if($task->status == 'pending') Pending
                        @elseif($task->status == 'in_progress') In Progress
                        @else Completed
                        @endif
                    </span>
                </div>

                @if($task->due_date)
                    <div class="task-date">
                        Due: {{ $task->due_date instanceof \DateTime ? $task->due_date->format('M d, Y') : $task->due_date }}
                    </div>
                @endif

                @if($task->tags->count() > 0)
                    <div class="task-tags">
                        @foreach($task->tags as $tag)
                            <span class="tag" style="background: {{ $tag->color }}20; color: {{ $tag->color }};">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif

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

    <div class="pagination">
        {{ $tasks->appends(request()->query())->links() }}
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#bulk-delete').click(function() {
        let ids = $('.task-checkbox:checked').map(function() { return $(this).val(); }).get();
        if (ids.length > 0) {
            if(confirm('Are you sure you want to delete selected tasks?')) {
                $.ajax({
                    url: "{{ route('tasks.bulkDelete') }}",
                    type: 'POST',
                    data: { _token: "{{ csrf_token() }}", ids: ids },
                    success: function() { location.reload(); }
                });
            }
        } else {
            alert('Please select at least one task!');
        }
    });
</script>

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f5f5; padding: 40px 20px; }
    .container { max-width: 1200px; margin: 0 auto; }
    .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; background: white; padding: 20px 30px; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .btn-new { background: #4CAF50; color: white; padding: 8px 16px; border-radius: 5px; text-decoration: none; font-size: 14px; }
    .search-box { background: white; padding: 20px; border-radius: 10px; margin-bottom: 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .search-form { display: flex; gap: 10px; flex-wrap: wrap; }
    .search-input { flex: 2; padding: 8px 12px; border: 1px solid #ddd; border-radius: 5px; }
    .filter-select { flex: 1; padding: 8px 12px; border: 1px solid #ddd; border-radius: 5px; }
    .btn-filter { background: #2196F3; color: white; padding: 8px 16px; border: none; border-radius: 5px; cursor: pointer; }
    .btn-reset { background: #9E9E9E; color: white; padding: 8px 16px; border-radius: 5px; text-decoration: none; }
    .success-msg { background: #e8f5e9; color: #2e7d32; padding: 12px 20px; border-radius: 5px; margin-bottom: 20px; border-left: 3px solid #4CAF50; }
    .tasks-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px; }
    .task-card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .task-title { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; }
    .task-desc { color: #666; font-size: 13px; line-height: 1.5; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
    .priority-badge { display: inline-block; padding: 4px 10px; border-radius: 3px; font-size: 12px; margin-bottom: 8px; }
    .priority-high { background: #ffebee; color: #c62828; }
    .priority-medium { background: #fff3e0; color: #ef6c00; }
    .priority-low { background: #e8f5e9; color: #2e7d32; }
    .status-badge { display: inline-block; padding: 4px 10px; border-radius: 3px; font-size: 12px; margin-bottom: 8px; }
    .status-pending { background: #fff9c4; color: #f57f17; }
    .status-in_progress { background: #e3f2fd; color: #1565c0; }
    .status-completed { background: #e8f5e9; color: #2e7d32; }
    .task-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 15px; }
    .tag { padding: 3px 8px; border-radius: 3px; font-size: 11px; }
    .task-actions { display: flex; gap: 8px; padding-top: 12px; border-top: 1px solid #eee; }
    .btn-view, .btn-edit, .btn-complete, .btn-delete { padding: 5px 12px; border-radius: 3px; text-decoration: none; font-size: 12px; border: 1px solid; cursor: pointer; }
    .btn-view { border-color: #2196F3; color: #2196F3; }
    .btn-edit { border-color: #FF9800; color: #FF9800; }
    .btn-complete { border-color: #4CAF50; color: #4CAF50; }
    .btn-delete { border-color: #f44336; color: #f44336; background: white; }
    .pagination { display: flex; justify-content: center; margin-top: 30px; }
</style>
@endsection
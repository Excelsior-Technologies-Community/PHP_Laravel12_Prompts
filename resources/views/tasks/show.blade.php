@extends('layouts.app')

@section('title', $task->title)

@section('content')
<div class="card">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <h2 class="mb-0">
                @if($task->is_featured)
                    <i class="fas fa-star text-warning"></i>
                @endif
                {{ $task->title }}
            </h2>
            <div>
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-custom">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-custom">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="mb-4">
                    <h5><i class="fas fa-align-left me-2"></i>Description</h5>
                    <p class="text-muted">{{ $task->description ?? 'No description provided.' }}</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title">Task Information</h6>
                        <hr>
                        <p><strong>Priority:</strong> {!! $task->priority_badge !!}</p>
                        <p><strong>Status:</strong> {!! $task->status_badge !!}</p>
                        @if($task->due_date)
                            <p><strong>Due Date:</strong> {{ $task->due_date->format('F d, Y') }}</p>
                        @endif
                        <p><strong>Created:</strong> {{ $task->created_at->format('M d, Y H:i') }}</p>
                        <p><strong>Last Updated:</strong> {{ $task->updated_at->diffForHumans() }}</p>
                        
                        @if($task->tags->count() > 0)
                            <p><strong>Tags:</strong></p>
                            <div>
                                @foreach($task->tags as $tag)
                                    <span class="badge" style="background: {{ $tag->color }}; color: white; margin-right: 5px;">
                                        <i class="fas fa-tag"></i> {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
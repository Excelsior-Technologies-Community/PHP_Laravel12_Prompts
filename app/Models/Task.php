<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    
    protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
        'due_date',
        'is_featured'
    ];

    protected $casts = [
        'due_date' => 'date',
        'is_featured' => 'boolean',
    ];

    // Define the many-to-many relationship with explicit pivot table name
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'task_tag', 'task_id', 'tag_id')
                    ->withTimestamps();
    }

    public function getPriorityBadgeAttribute()
    {
        return match($this->priority) {
            'high' => '<span class="badge badge-danger">High</span>',
            'medium' => '<span class="badge badge-warning">Medium</span>',
            'low' => '<span class="badge badge-success">Low</span>',
            default => '<span class="badge badge-secondary">'.$this->priority.'</span>',
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'completed' => '<span class="badge badge-success">Completed</span>',
            'in_progress' => '<span class="badge badge-primary">In Progress</span>',
            'pending' => '<span class="badge badge-secondary">Pending</span>',
            default => '<span class="badge badge-secondary">'.$this->status.'</span>',
        };
    }
}
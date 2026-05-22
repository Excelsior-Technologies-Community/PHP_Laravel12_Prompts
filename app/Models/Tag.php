<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';
    
    protected $fillable = ['name', 'color'];

    // Define the many-to-many relationship with explicit pivot table name
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_tag', 'tag_id', 'task_id')
                    ->withTimestamps();
    }
}
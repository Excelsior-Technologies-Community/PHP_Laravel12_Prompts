<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        // First, clear existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Task::truncate();
        Tag::truncate();
        DB::table('task_tag')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        // Create tags
        $tags = [
            ['name' => 'Work', 'color' => '#EF4444', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Personal', 'color' => '#10B981', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Urgent', 'color' => '#F59E0B', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Study', 'color' => '#3B82F6', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Meeting', 'color' => '#8B5CF6', 'created_at' => now(), 'updated_at' => now()],
        ];
        
        foreach ($tags as $tag) {
            Tag::create($tag);
        }
        
        // Get all tag IDs
        $tagIds = Tag::pluck('id')->toArray();
        
        // Create tasks
        $tasks = [
            [
                'title' => 'Complete Laravel Project',
                'description' => 'Finish the task management system with all features.',
                'priority' => 'high',
                'status' => 'in_progress',
                'due_date' => now()->addDays(5),
                'is_featured' => true,
            ],
            [
                'title' => 'Team Meeting',
                'description' => 'Weekly sync with development team.',
                'priority' => 'medium',
                'status' => 'pending',
                'due_date' => now()->addDays(2),
                'is_featured' => false,
            ],
            [
                'title' => 'Buy Groceries',
                'description' => 'Milk, eggs, bread, vegetables.',
                'priority' => 'low',
                'status' => 'pending',
                'due_date' => now()->addDays(1),
                'is_featured' => false,
            ],
            [
                'title' => 'Review Code',
                'description' => 'Review pull requests from team members.',
                'priority' => 'high',
                'status' => 'in_progress',
                'due_date' => now()->addDays(1),
                'is_featured' => true,
            ],
            [
                'title' => 'Write Documentation',
                'description' => 'Update API documentation.',
                'priority' => 'medium',
                'status' => 'pending',
                'due_date' => now()->addDays(7),
                'is_featured' => false,
            ],
            [
                'title' => 'Prepare Presentation',
                'description' => 'Create slides for client demo.',
                'priority' => 'high',
                'status' => 'pending',
                'due_date' => now()->addDays(4),
                'is_featured' => true,
            ],
            [
                'title' => 'Exercise',
                'description' => '30 minutes cardio workout.',
                'priority' => 'low',
                'status' => 'completed',
                'due_date' => now()->subDays(1),
                'is_featured' => false,
            ],
            [
                'title' => 'Pay Bills',
                'description' => 'Electricity and internet bills.',
                'priority' => 'high',
                'status' => 'pending',
                'due_date' => now()->addDays(3),
                'is_featured' => false,
            ],
        ];
        
        // Create tasks and attach tags
        foreach ($tasks as $taskData) {
            $task = Task::create($taskData);
            
            // Attach 1-3 random tags to each task
            $randomTags = (array) array_rand(array_flip($tagIds), rand(1, 3));
            if (!empty($randomTags)) {
                foreach ($randomTags as $tagId) {
                    DB::table('task_tag')->insert([
                        'task_id' => $task->id,
                        'tag_id' => $tagId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
        
        $this->command->info('✓ Tasks seeded successfully!');
        $this->command->info('  Total tasks: ' . Task::count());
        $this->command->info('  Total tags: ' . Tag::count());
        $this->command->info('  Total relationships: ' . DB::table('task_tag')->count());
    }
}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CliUser;

class ShowUsers extends Command
{
    protected $signature = 'prompt:users';
    protected $description = 'Display all registered CLI users';

    public function handle()
    {
        $this->info("📋 Registered Users List");

        $users = CliUser::all();

        // If no users
        if ($users->isEmpty()) {
            $this->warn("No users found!");
            return;
        }

        // Format data for table
        $data = $users->map(function ($user) {
            return [
                $user->id,
                $user->email,
                $user->created_at->format('Y-m-d H:i')
            ];
        });

        // Show table
        $this->table(
            ['ID', 'Email', 'Created At'],
            $data
        );

        $this->info("✅ Users displayed successfully!");
    }
}
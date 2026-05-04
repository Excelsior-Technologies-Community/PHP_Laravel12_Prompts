<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PromptMenu extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'prompt:menu';

    /**
     * The console command description.
     */
    protected $description = 'Main menu to run all prompt demos';

    public function handle()
    {
        $this->info("✨ Welcome to Laravel 12 CLI Menu ✨\n");

        // Updated menu options
        $choice = $this->choice(
            'Select a demo to run',
            [
                'User Registration',
                'View Users',
                'Demo Prompt'
            ],
            0
        );

        // Handle user selection
        if ($choice === 'User Registration') {
            $this->call('prompt:register');

        } elseif ($choice === 'View Users') {
            $this->call('prompt:users');

        } else {
            $this->call('prompt:demo');
        }

        $this->newLine();
        $this->info("✅ Menu finished!");
    }
}
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

        // Use built-in choice() instead of Prompts::select
        $choice = $this->choice(
            'Select a demo to run',
            ['User Registration', 'Demo Prompt'],
            0 // default index
        );

        if ($choice === 'User Registration') {
            $this->call('prompt:register');
        } else {
            $this->call('prompt:demo');
        }

        $this->newLine();
        $this->info("✅ Menu finished!");
    }
}
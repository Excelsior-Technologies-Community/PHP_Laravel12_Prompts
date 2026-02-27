<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DemoPromptCommand extends Command
{
    protected $signature = 'prompt:demo';
    protected $description = 'Demo interactive prompts in Laravel 12';

    public function handle()
    {
        $this->info("Laravel 12 Interactive CLI Demo");

        // Ask for text input
        $name = $this->ask('What is your name?');

        // Confirm yes/no
        $confirm = $this->confirm('Do you want to proceed?', true);

        if (! $confirm) {
            $this->warn("Action cancelled!");
            return;
        }

        // Choice prompt
        $language = $this->choice(
            'Choose your favorite language',
            ['PHP', 'JavaScript', 'Python'],
            0
        );

        $this->info("Your name is: $name");
        $this->info("Favorite language: $language");
        $this->info("✨ Prompt execution finished!");
    }
}
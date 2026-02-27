<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RegistrationPrompt extends Command
{
    protected $signature = 'prompt:register';
    protected $description = 'Collect user registration through interactive prompts in Laravel 12';

    public function handle()
    {
        $this->info("User Registration");

        // Ask for email
        $email = $this->ask('Enter your email');

        // Ask for password (hidden input)
        $password = $this->secret('Enter a password');

        // Confirm terms
        $terms = $this->confirm('Do you accept terms and conditions?', false);

        if (! $terms) {
            $this->error("You must accept terms!");
            return;
        }

        $this->info("✅ Registered successfully with email: $email");
    }
}
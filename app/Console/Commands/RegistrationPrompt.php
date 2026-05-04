<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CliUser;
use Illuminate\Support\Facades\Hash;

class RegistrationPrompt extends Command
{
    protected $signature = 'prompt:register';
    protected $description = 'Collect user registration through interactive prompts in Laravel 12';

    public function handle()
    {
        $this->info("User Registration");

        // Ask for email
        $email = $this->ask('Enter your email');

        // Validate email 
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error("Invalid email format!");
            return;
        }

        // Ask for password (hidden input)
        $password = $this->secret('Enter a password');

        if (strlen($password) < 6) {
            $this->error("Password must be at least 6 characters!");
            return;
        }

        // Confirm terms
        $terms = $this->confirm('Do you accept terms and conditions?', false);

        if (! $terms) {
            $this->error("You must accept terms!");
            return;
        }

        // Save to database
        CliUser::create([
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        // Success message
        $this->info("✅ Registered successfully with email: $email");
    }
}
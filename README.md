# PHP_Laravel12_Prompts

## Project Description

PHP_Laravel12_Prompts is a Laravel 12 based CLI project that demonstrates how to create interactive command-line prompts.

It allows you to:

Collect user input via the terminal using text, password, confirmation, and selection prompts.

Simulate workflows like user registration in a CLI environment.

Provide a menu interface to select and run multiple commands interactively.

Practice Laravel Artisan commands and understand how to handle interactive CLI input without requiring third-party packages (fully compatible with Laravel 12).


## Technologies Used:

1. Laravel 12 – PHP framework for building the project.

2. PHP 8.x – Core language for the application.

3. MySQL – Database support (optional, for future use).

4. Artisan CLI – Built-in Laravel console tool for running commands.



## Features

1. Interactive CLI Experience – Engage with the terminal using prompts for text, password, confirmation, and choice selection.

2. User Registration Simulation – Collect user email, password, and terms acceptance interactively.

3. Command Menu System – Central menu to run multiple CLI commands effortlessly.

4. Laravel 12 Compatibility – Fully functional without extra packages, using built-in Artisan methods.

5. Real-time Input Validation – Ensures required inputs are collected before proceeding.

6. Flexible & Extendable – Easily add new commands, prompts, or workflows for demos or projects.

7. Lightweight & Beginner-Friendly – Perfect for developers learning CLI interaction in Laravel.

8. Reusable Demo Framework – Can be used as a base for any interactive CLI-based project in Laravel.

---



## Installation Steps


---


## STEP 1: Create Laravel 12 Project

### Open terminal / CMD and run:

```
composer create-project laravel/laravel PHP_Laravel12_Prompts "12.*"

```

### Go inside project:

```
cd PHP_Laravel12_Prompts

```

#### Explanation:

Installs a fresh Laravel 12 project and navigates into the project folder.





## STEP 2: Database Setup (Optional)

### Update database details:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_prompt
DB_USERNAME=root
DB_PASSWORD=

```

### Create database in MySQL / phpMyAdmin:

```
Database name: laravel12_prompt

```

#### Explanation:

Sets up a MySQL database connection for future use in your Laravel app.





## STEP 3: Install Prompt Packages

### Install the package:

```
composer require laravel/prompts

```


#### Explanation:

Installs the Laravel Prompts package (only needed if using Laravel 13+; for Laravel 12, built-in methods will work).





## STEP 4: Make a New Artisan Command

### Run:

```
php artisan make:command DemoPromptCommand

```

### This creates: app/Console/Commands/DemoPromptCommand.php

```
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
        $this->info(" Prompt execution finished!");
    }
}

```

#### Explanation:

Generates a new command to create interactive CLI prompts.

This command demonstrates text input, confirmation, and selection prompts.






## STEP 5: Run the Prompt Command

### Run:

```
php artisan prompt:demo

```


### You will see:

```
What is your name?
> _

Do you want to proceed? (yes/no) [yes]
> _

Choose your favorite language
?  > PHP
   > JavaScript
   > Python

```


### You will see this type:


<img width="1439" height="440" alt="Screenshot 2026-02-27 171830" src="https://github.com/user-attachments/assets/b0214161-c4a6-4682-9317-4fff25041ca3" />



#### Explanation:

Runs the demo prompt command and interactively collects user input.

Creates a new command to simulate a user registration workflow.

Collects email, password, and user confirmation interactively in the CLI.




## STEP 7: Add Another Prompt Example

### You can make another example command:

```
php artisan make:command RegistrationPrompt

```

### Replace in app/Console/Commands/RegistrationPrompt.php:

```
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

        $this->info("Registered successfully with email: $email");
    }
}

```


### Run:

```
php artisan prompt:register

```

### You will see this type:


<img width="1466" height="364" alt="Screenshot 2026-02-27 171205" src="https://github.com/user-attachments/assets/80e12e14-b53d-498a-9cdd-b300d05b6f6c" />




#### Explanation:

Executes the registration prompt command in the terminal.

Creates a main menu command to run multiple prompt commands from a single interface.

Allows the user to select and run either the demo or registration command from a simple menu.








## STEP 8: Create a Demo Menu Command

### You can create a main menu to run multiple prompt commands:

```
php artisan make:command PromptMenu

```

### Replace in app/Console/Commands/PromptMenu.php

```
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
        $this->info(" Welcome to Laravel 12 CLI Menu \n");

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
        $this->info(" Menu finished!");
    }
}

```


### Then you just run:

```
php artisan prompt:menu

```


### You will see this type:


<img width="1462" height="558" alt="Screenshot 2026-02-27 172421" src="https://github.com/user-attachments/assets/8721e4ce-1617-4c7f-8aaf-187f48bf7e9c" />


#### Explanation:

Displays the main menu and executes the chosen command interactively.




---

# Project Folder Structure:

```
PHP_Laravel12_Prompts/
├── app/
│   └── Console/
│       └── Commands/
│           ├── DemoPromptCommand.php
│           ├── RegistrationPrompt.php
│           └── PromptMenu.php
├── artisan
├── composer.json
└── .env

```


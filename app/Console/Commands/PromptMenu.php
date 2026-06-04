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
    protected $description = 'Main menu to run all prompt demos, view history, and export data';

    public function handle()
    {
        $this->info("✨ Welcome to Laravel 12 CLI Menu ✨\n");

        $choice = $this->choice(
            'Select an option:',
            [
                'User Registration',
                'View Users',
                'Demo Prompt',
                'View Prompt History',
                'Export/Import Prompts'
            ],
            0
        );

        switch ($choice) {
            case 'User Registration':
                $this->call('prompt:register');
                break;
            case 'View Users':
                $this->call('prompt:users');
                break;
            case 'Demo Prompt':
                $this->call('prompt:demo');
                break;
            case 'View Prompt History':
                $this->showHistory();
                break;
            case 'Export/Import Prompts':
                $this->call('prompt:export-import');
                break;
        }

        $this->newLine();
        $this->info("✅ Menu finished!");
    }

   protected function showHistory()
{
    
    $histories = \App\Models\PromptHistory::latest()->take(10)->get();

    if ($histories->isEmpty()) {
        $this->warn('No history found!');
        return;
    }

    $this->table(['ID', 'Prompt', 'Response', 'Created At'], $histories->map(function ($item) {
        return [$item->id, $item->prompt_text, substr($item->response, 0, 20) . '...', $item->created_at->format('Y-m-d')];
    }));
}
}
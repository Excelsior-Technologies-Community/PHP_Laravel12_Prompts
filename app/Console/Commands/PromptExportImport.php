<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PromptHistory;

class PromptExportImport extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'prompt:export-import';

    /**
     * The console command description.
     */
    protected $description = 'Export or Import prompt history data in JSON format';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->choice('Select action:', ['Export', 'Import']);

        if ($action === 'Export') {
            $data = PromptHistory::all()->toJson(JSON_PRETTY_PRINT);
            file_put_contents(storage_path('prompts_export.json'), $data);
            $this->info('Data successfully exported to storage/prompts_export.json');
        } else {
            $path = storage_path('prompts_export.json');
            if (file_exists($path)) {
                $data = json_decode(file_get_contents($path), true);
                
                foreach ($data as $item) {
                    PromptHistory::updateOrCreate(
                        ['id' => $item['id']], // Use ID to prevent duplicates
                        [
                            'prompt_text' => $item['prompt_text'],
                            'response' => $item['response'],
                            'created_at' => $item['created_at'],
                            'updated_at' => $item['updated_at']
                        ]
                    );
                }
                $this->info('Data successfully imported into the database!');
            } else {
                $this->error('File prompts_export.json not found in storage!');
            }
        }
    }
}
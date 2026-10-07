<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SubmitWebsiteIndex extends Command
{
    protected $signature = 'website:index {urls?* : Optional same-host URLs; all published URLs are used when omitted}';

    protected $description = 'Alias for website:indexnow to submit published website URLs for indexing';

    public function handle(): int
    {
        return $this->call('website:indexnow', [
            'urls' => $this->argument('urls'),
        ]);
    }
}

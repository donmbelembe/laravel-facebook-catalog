<?php

namespace Donmbelembe\LaravelFacebookCatalog\Commands;

use Illuminate\Console\Command;

class LaravelFacebookCatalogCommand extends Command
{
    public $signature = 'laravel-facebook-catalog';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}

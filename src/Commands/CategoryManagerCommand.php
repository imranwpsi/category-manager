<?php

namespace Ihossain\CategoryManager\Commands;

use Illuminate\Console\Command;

class CategoryManagerCommand extends Command
{
    public $signature = 'category-manager';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}

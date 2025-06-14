<?php

namespace Ihossain\CategoryManager;

use Ihossain\CategoryManager\Commands\CategoryManagerCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CategoryManagerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('category-manager')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_category_manager_table')
            ->hasCommand(CategoryManagerCommand::class);
    }
}

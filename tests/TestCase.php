<?php

namespace Ihossain\CategoryManager\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Ihossain\CategoryManager\CategoryManagerServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Ihossain\\CategoryManager\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            CategoryManagerServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        // Register test models namespace
        $app['config']->set('app.providers', array_merge(
            $app['config']->get('app.providers'),
            [CategoryManagerServiceProvider::class]
        ));

        // Load migrations
        include_once __DIR__.'/../database/migrations/create_categories_table.php.stub';
        (new \CreateCategoriesTable())->up();

        // Create tables for test models
        \Schema::create('posts', function ($table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });

        \Schema::create('products', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }
}

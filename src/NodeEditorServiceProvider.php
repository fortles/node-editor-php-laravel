<?php

namespace Fortles\LaravelNodeEditor;

use Blade;
use Illuminate\Support\ServiceProvider;

class NodeEditorServiceProvider extends ServiceProvider 
{
    public function boot()
    {
        // Load migrations from your package's migration path
        $this->loadMigrationsFrom(__DIR__.'/migrations');

        Blade::directive('nodeEditorScripts', function () {
            return '<script src="'.asset(config('asset_route_prefix').'/NodeEditor.js').'"></script>';
        });
    
        Blade::directive('nodeEditorStyles', function () {
            return '<link rel="stylesheet" href="'.asset(config('asset_route_prefix').'/style.css').'">';
        });

        $this->loadRoutesFrom(__DIR__.'/routes.php');
        
        // Allow users to publish migrations to their application's migrations directory
        if ($this->app->runningInConsole()) {

            //Migrations
            $this->publishes([
                __DIR__.'/migrations' => database_path('migrations'),
            ], 'laravel-node-editor-migrations');

            //Config
            $this->publishes([
                __DIR__.'/config/laravel-node-editor.php' => config_path('laravel-node-editor.php'),
            ], 'config');

            //Assets
            $this->publishes([
                __DIR__.'/../vendor/fortles/node-editor/asset' => public_path(config('asset_route_prefix')),
            ], 'public');
        }
    }

    public function register()
{
    $this->mergeConfigFrom(
        __DIR__.'/config/fortles-node-editor.php', 'fortles-node-editor'
    );
}
}
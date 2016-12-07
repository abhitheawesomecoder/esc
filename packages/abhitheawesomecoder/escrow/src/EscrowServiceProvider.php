<?php

namespace Abhitheawesomecoder\Escrow;

use Illuminate\Support\ServiceProvider;

class EscrowServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
     public function boot()
     {
          $this->loadViewsFrom(__DIR__.'/views', 'escrow');
          $this->publishes([
          __DIR__.'/migrations' =>  database_path('/migrations')
         ], 'migrations');
           $this->publishes([
           __DIR__.'/seeds' =>  database_path('/seeds')
         ], 'seeds');
 	  	/*   $this->publishes([
         __DIR__.'/assets' => public_path('vendor/abhitheawesomecoder/jobboardpro'),
       ], 'public');*/
          $this->publishes([
          __DIR__.'/views' =>  base_path('resources/views/vendor/abhitheawesomecoder/escrow')
         ], 'views');
      /*   $this->publishes([
         __DIR__.'/auth' =>  base_path('resources/views/auth')
        ], 'auth');
        $this->publishes([
        __DIR__.'/layouts' =>  base_path('resources/views/layouts')
      ], 'layouts');*/
         $this->publishes([
         __DIR__.'/Models' =>  base_path('app')
       ], 'models');

     }

    /**
     * Register the application services.
     *
     * @return void
     */
     public function register()
     {
         include __DIR__.'/routes.php';
         $this->app->make('Abhitheawesomecoder\Escrow\Controllers\TransferController');

     }
}

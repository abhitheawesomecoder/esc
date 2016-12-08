<?php

namespace Abhitheawesomecoder\Escrow;

use Illuminate\Support\ServiceProvider;
use App\Extensions;
class EscrowServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
     public function boot()
     {
       // extension installation starts
               $path = public_path('../packages/abhitheawesomecoder');
               $pathescrow = public_path('../packages/abhitheawesomecoder/escrow');

              if(file_exists($path)){
                if(file_exists($pathescrow)){
                  $arr = [];
                   foreach (scandir($path)as $key => $value) {
                     if((strpos($value, 'escrow') !== false)&&(strlen($value) > 6)){
                       $str = str_replace("escrow","",$value);
                       $this->installextensions($str);
                       array_push($arr,$str);
                     }
                   }
                   // loop through the extension list
                   // check if the extension name matches with any of the directory name
                   // if not then delete it
                    Extensions::whereNotIn("name",$arr)->delete();
              }
             }
     // extension installation ends

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
     function installextensions($extname){
       $ext = Extensions::where("name",$extname)->first();
       if($ext){
       }else{

         $ext = new Extensions;
         $ext->name = $extname;
         $ext->url = $extname."-d";
         $ext->status = 0;
         $ext->type = 1;
         $ext->save();

         $ext = new Extensions;
         $ext->name = $extname;
         $ext->url = $extname."-w";
         $ext->status = 0;
         $ext->type = 2;
         $ext->save();

       }
     }
     public function register()
     {

         include __DIR__.'/routes.php';
         $this->app->make('Abhitheawesomecoder\Escrow\Controllers\TransferController');

     }
}

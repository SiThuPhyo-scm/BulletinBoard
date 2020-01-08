<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Dao Registration
        $this->app->bind('App\Contracts\Dao\Post\PostDaoInterface', 'App\Dao\Post\PostDao');
        $this->app->bind('App\Contracts\Dao\User\UserDaoInterface', 'App\Dao\User\UserDao');

        // Business logic registration
        $this->app->bind('App\Contracts\Services\Post\PostServiceInterface', 'App\Services\Post\PostService');
        $this->app->bind('App\Contracts\Services\User\UserServiceInterface', 'App\Services\User\UserService');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Debug log for SQL
        DB::listen(
            function ($sql) {
              foreach ($sql->bindings as $i => $binding) {
                if ($binding instanceof \DateTime) {
                  $sql->bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                } else {
                  if (is_string($binding)) {
                    $sql->bindings[$i] = "'$binding'";
                  }
                }
              }
              // Insert bindings into query
              $query = str_replace(array('%', '?'), array('%%', '%s'), $sql->sql);
              $query = vsprintf($query, $sql->bindings);
              Log::debug($query);
            }
          );
    }
}

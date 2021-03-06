<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\PacienteRepository::class, \App\Repositories\PacienteRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UbsRepository::class, \App\Repositories\UbsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ComorbidadeRepository::class, \App\Repositories\ComorbidadeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CampanhaRepository::class, \App\Repositories\CampanhaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CampanhaAgendamentoRepository::class, \App\Repositories\CampanhaAgendamentoRepositoryEloquent::class);
        //:end-bindings:
    }
}

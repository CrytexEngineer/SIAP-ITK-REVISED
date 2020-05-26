<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('change', function ($id){
            return $id->hasAnyRoles(['Super Admin', 'Admin', 'Wakil Rektor', 'Tendik Jurusan', 'Tendik Pusat']);
        });

        Gate::define('tendik-pusat', function ($id){
            return $id->hasAnyRoles(['Super Admin', 'Tendik Pusat']);
        });

        Gate::define('admin', function ($id){
            return $id->hasAnyRoles(['Super Admin', 'Admin', 'Observer', 'Wakil Rektor', 'Ketua Prodi', 'Ketua Jurusan', 'Tendik Jurusan', 'Tendik Pusat']);
        });

        Gate::define('dosen', function ($id){
            return $id->hasRole('Dosen Pengampu');
        });
    }
}

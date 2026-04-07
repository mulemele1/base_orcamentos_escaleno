<?php

namespace App\Providers;

use App\Models\Projeto;
use App\Policies\ProjetoPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Registrar a política do Projeto
        Projeto::class => ProjetoPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate para verificar se é usuário comum
        Gate::define('is_user', function ($user) {
            return in_array($user->type, ['user', 'super', 'admin']);
        });

        // Gate para verificar se é administrador
        Gate::define('is_admin', function ($user) {
            return in_array($user->type, ['admin', 'super']);
        });

        // Gate para verificar se é super usuário
        Gate::define('is_super', function ($user) {
            return $user->type === 'super';
        });
        
        // Gate para verificar se o usuário é o dono do projeto
        Gate::define('is_owner', function ($user, $projeto) {
            return $user->id === $projeto->user_id;
        });
    }
}
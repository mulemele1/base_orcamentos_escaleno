<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Projeto;

class ProjetoPolicy
{
    /**
     * Determine if the user can view the project.
     */
    public function view(User $user, Projeto $projeto): bool
    {
        // Usuário pode ver se é o dono ou é admin/super
        return $user->id === $projeto->user_id || in_array($user->type, ['admin', 'super']);
    }
    
    /**
     * Determine if the user can create projects.
     */
    public function create(User $user): bool
    {
        // Qualquer usuário autenticado pode criar projetos
        return true;
    }
    
    /**
     * Determine if the user can update the project.
     */
    public function update(User $user, Projeto $projeto): bool
    {
        // Usuário pode atualizar se é o dono ou é admin/super
        return $user->id === $projeto->user_id || in_array($user->type, ['admin', 'super']);
    }
    
    /**
     * Determine if the user can delete the project.
     */
    public function delete(User $user, Projeto $projeto): bool
    {
        // Apenas o dono ou super podem excluir
        return $user->id === $projeto->user_id || $user->type === 'super';
    }
}
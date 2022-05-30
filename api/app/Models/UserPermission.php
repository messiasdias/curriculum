<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    protected $table = "user_permissions";

    protected $fillable = [
        'users_id',
        'users',
        'pages',
        'cases',
        'slider',
        'images',
        'solutions',
        'inbox'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'users' => 'boolean',
        'pages' => 'boolean',
        'cases' => 'boolean',
        'slider' => 'boolean',
        'images' => 'boolean',
        'solutions' => 'boolean',
        'inbox' => 'boolean',
    ];

    const ADMIN = [
        'users' => true,
        'pages' => true,
        'cases' => true,
        'slider' => true,
        'images' => true,
        'solutions' => true,
        'inbox' => true
    ];

    const MANAGER = [
        'users' => false,
        'pages' => true,
        'cases' => true,
        'slider' => true,
        'images' => true,
        'solutions' => true,
        'inbox' => true
    ];

    const PERMISSIONS = [
        'users' => 'Usuários',
        'pages' => 'Páginas',
        'cases' => 'Cases',
        'slider' => 'Sliders',
        'images' => 'Imagens',
        'solutions' => 'Soluções',
        'inbox' => 'Contatos'
    ];

    const TYPES = [
        'admin' => "Administrador",
        'manager' => "Gerente",
    ];
}

<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Use the correct class for authentication
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable // Extend the correct class
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $primaryKey = 'id'; // Defining the primary key

    protected $table = 'users'; // Specify the table if not default

    protected $fillable = [
        'username', 'email', 'password', 'role_id', 'tel'
    ];

    // Relationship with Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relationship with Documents
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    // Relationship with Permissions (many-to-many)
    public function permissions(): BelongsToMany
{
    return $this->belongsToMany(Permission::class, 'permission_user', 'user_id', 'permission_id');
}

    
}

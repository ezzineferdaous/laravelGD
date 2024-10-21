<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $primaryKey = 'id_permission';  // Specify your custom primary key

    public $timestamps = false;  // If your table doesn't use timestamps

    protected $fillable = ['name', 'description'];  // List fillable attributes 
    public function users()
    {
        return $this->belongsToMany(User::class, 'permission_user');
    }
    
}


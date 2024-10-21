<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PermissionUser extends Pivot
{
    // Define the table name if it's different from the default convention (permission_user)
    protected $table = 'permission_user';

    // Disable timestamps if your table doesn't have 'created_at' and 'updated_at' columns
    public $timestamps = false;

    // Define the fillable fields
    protected $fillable = [
        'user_id',
        'permission_id',
    ];

    /**
     * Get the user that owns the permission.
     */
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');  // Ensure 'user_id' is correct
}

public function permission()
{
    return $this->belongsTo(Permission::class, 'permission_id', 'id_permission');  // Use 'id_permission' as the primary key in the Permission model
}

}

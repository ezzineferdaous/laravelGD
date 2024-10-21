<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    // Optionally specify the table name if it's not the plural of the model name
     protected $table = 'documents';
     protected $primaryKey = 'id';


    // Fillable fields for mass assignment
    protected $fillable = [
        'title',
        'content',
        'format',
        'file_path',
        'category_id', // Foreign key to categories table
        'user_id',     // Foreign key to users table
    ];

    // Define relationships
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id_category');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

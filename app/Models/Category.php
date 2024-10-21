<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    protected $primaryKey = 'id_category';

    public $incrementing = true;


    protected $fillable = [
        'name',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class, 'category_id', 'id_category');
    }

}

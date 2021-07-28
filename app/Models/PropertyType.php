<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'title','description', 'created_at', 'updated_at'];

    public function property()
    {
        return $this->hasMany(Property::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NutritionResult extends Model
{
    protected $fillable = ['user_id', 'image_path', 'analysis'];
}


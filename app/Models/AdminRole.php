<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Mongodb\Laravel\Eloquent\Model as Model;

class AdminRole extends Model
{
    use HasFactory;

    protected $guarded = [];
}

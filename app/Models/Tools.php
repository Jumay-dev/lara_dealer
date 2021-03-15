<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tools extends ExtraModel
{
    use HasFactory;

    protected $table = 'tools';

    public static function setObject()
    {
        return 'tools';
    }
}

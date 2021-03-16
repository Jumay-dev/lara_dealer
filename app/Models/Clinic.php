<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends ExtraModel
{
    use HasFactory;

    protected $table = 'clinics';

    public static function setObject()
    {
        return "clinics";
    }
}

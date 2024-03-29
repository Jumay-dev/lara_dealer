<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends ExtraModel
{
    use HasFactory;

    protected $table = 'categories';

    public static function setObject()
    {
        return "categories";
    }

    public function tools()
    {
        return $this->hasMany(Tools::class);
    }
}

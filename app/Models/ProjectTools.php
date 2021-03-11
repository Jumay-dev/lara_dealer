<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTools extends ExtraModel
{
    use HasFactory;

    protected $table = 'projects_tools';

    public static function setObject(){
        return "project_tools";
    }


}

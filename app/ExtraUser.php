<?php

// namespace App\Http\Controllers;
namespace App;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Traits\HasRoles;

class ExtraUser extends User
{
    use HasRoles;
    protected $table = "users";

    public function find($id) {
        return parent::find($id);
    }

//    public static function find($options) {
//        return parent::find($options);
//    }
}

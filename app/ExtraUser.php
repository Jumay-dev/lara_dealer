<?php

// namespace App\Http\Controllers;
namespace App;

use Illuminate\Http\Request;
use App\User;

class ExtraUser extends User
{
    protected $table = "users";
}

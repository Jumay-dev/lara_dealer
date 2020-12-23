<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpaController extends Controller
{
  public function index()
  {
    // // DS.Med manager
    // Role::create(['name'=>"manager"]);
    // // DS.Med director
    // Role::create(['name'=>"admin"]);
    // // Dealer company director
    // Role::create(['name'=>"dealer"]);
    // // Dealer company employee
    // Role::create(['name'=>"employee"]);

    return view('spa');
  }
}
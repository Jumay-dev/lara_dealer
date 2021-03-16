<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends ExtraModel
{
    protected $table = "companies";
    use HasFactory;

//    public function companyDetals() {
//        return $this->hasMany('App\Models\Clinic', 'company_id', 'id');
//    }

    public function companyDirector() {
        return $this->hasOne('App\ExtraUser', 'id', 'director_id');
    }
}

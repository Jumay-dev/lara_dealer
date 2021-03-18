<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends ExtraModel
{
    protected $table = "companies";

    public function companyDetals(): HasMany
    {
        return $this->hasMany('App\Models\Clinic', 'company_id', 'id');
    }

    public function companyDirector(): HasOne
    {
        return $this->hasOne('App\ExtraUser', 'id', 'director_id');
    }
}

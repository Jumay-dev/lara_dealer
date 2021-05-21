<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $table = 'providers';

    public function template()
    {
        return $this->hasOne('App\Models\MailTemplate', 'provider_id', 'id');
    }
}

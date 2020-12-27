<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaCompany extends ExtraModel
{
    protected $table = 'meta_users';

    public static function setObject(){
        return "company";
    }

    public function saveOrFail(array $options = [])
    {
        if (!$this->created_by) {
            $this->created_by = auth()->user()->id;
        }
        return parent::saveOrFail($options);
    }
}

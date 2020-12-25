<?php

namespace App\Models;

class MetaUser extends ExtraModel
{
    protected $table = 'meta_users';
     public function user() {
         return $this->belongsTo('App\User', 'foreign_key', "id");
     }

    public static function setObject(){
        return "project";
    }

    public function saveOrFail(array $options = [])
    {
        if (!$this->created_by) {
            $this->created_by = auth()->user()->id;
        }
        return parent::saveOrFail($options);
    }
}

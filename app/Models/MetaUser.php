<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class MetaUser extends ExtraModel
{
    protected $table = 'meta_users';

    public static function setObject(){
        return "project";
    }

    public function saveOrFail(array $options = [])
    {
        if (!$this->created_by) {
            $this->created_by = auth()->user()->id;
        }
        if (!$this->updated_by) {
            $this->updated_by = auth()->user()->id;
        }
        return parent::saveOrFail($options);
    }
}

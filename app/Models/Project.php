<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectTools;

class Project extends ExtraModel
{
    protected $table = 'projects';

    public static function setObject()
    {
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

    public function projectTools()
    {
        return $this->hasMany('App\Models\ProjectTools', 'project_id', 'id');
    }

    public function projectClinics()
    {
        return $this->hasMany('App\Models\Clinic', 'project_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectTools;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

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
        return $this->hasMany('App\Models\ProjectTools', 'project_id', 'id')->orderBy('project_id', 'asc');
    }

    public function projectClinics()
    {
        return $this->hasMany('App\Models\Clinic', 'project_id', 'id');
    }

    public function projectDealer() {
        return $this->hasOne('App\Models\Company', 'id', 'dealer');
    }

    public function lastComment() {
        $comment = $this->hasOne('App\Models\Comments', 'entity_id', 'id')
            ->where('entity_type', 'PROJECT_COMMENT')
            ->orderBy('comments.created_at', 'desc')
            ->join('users', 'created_by', '=', 'users.id')
            ->select('comments.comment', 'comments.created_at', 'users.name', 'users.surname')
            ->limit(1);
        return $comment;
    }

    public function commentList() {
        return $this->hasMany('App\Models\Comments', 'entity_id', 'id')
            ->where('entity_type', 'PROJECT_COMMENT')
            ->orderBy('comments.created_at', 'desc')
            ->join('users', 'created_by', '=', 'users.id')
            ->select('comments.comment', 'comments.created_at', 'users.name', 'users.surname');
    }

//    public function getSearchResult(): SearchResult
//    {
//        return new \Spatie\Searchable\SearchResult(
//            $this,
//            $this->projectClinics->name,
//        );
//    }
}

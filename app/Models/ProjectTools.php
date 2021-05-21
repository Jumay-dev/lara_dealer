<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectTools extends ExtraModel
{
    use HasFactory;

    protected $table = 'project_tools';

    public static function setObject()
    {
        return "project_tools";
    }

    public function lastComment()
    {
        return $this->hasOne('App\Models\Comments', 'entity_id', 'id')
            ->where('comments.entity_type', 'TOOL_COMMENT')
            ->select(['comment', 'created_at'])
            ->orderBy('comments.created_at', 'desc')
            ->join('users', 'created_by', '=', 'users.id')
            ->select('comments.comment', 'comments.created_at', 'users.name', 'users.surname')
            ->limit(1);
    }

    public function comments() {
        return $this->hasMany('App\Models\Comments', 'entity_id', 'id')
            ->where('comments.entity_type', 'TOOL_COMMENT')
            ->select(['comment', 'created_at'])
            ->orderBy('comments.created_at', 'desc')
            ->join('users', 'created_by', '=', 'users.id')
            ->select('comments.comment', 'comments.created_at', 'users.name', 'users.surname');
    }


}

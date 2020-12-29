<?php

// namespace App\Http\Controllers;
namespace App;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Traits\HasRoles;

class ExtraUser extends User
{
    use HasRoles;
    protected $table = "users";

    public static function setObject()
    {
        return "user";
    }

    public static function getObject()
    {
        return static::setObject(); // Здесь действует позднее статическое связывание
    }

    public function find($id) {
        $current_user = auth()->user();
        if ($current_user) {
            if ($current_user->hasPermissionTo(static::getObject() . '_read')) {
                return parent::find($id);
            }
            throw new \Exception('Недостаточно прав');
        }
        throw new \Exception('Время действия вашей сессии истекло');
    }

    public function create(Array $options = []) {
        $current_user = auth()->user();
        if ($current_user) {
            if ($current_user->hasPermissionTo(static::getObject() . '_create')) {
                return parent::create($options);
            }
            throw new \Exception('Недостаточно прав');
        }
        throw new \Exception('Время действия вашей сессии истекло');
    }

    public static function all($columns = ['*']) {
        $current_user = auth()->user();
        if ($current_user) {
            return parent::all($columns = ['*']);
        }
    }
}

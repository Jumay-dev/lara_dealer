<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;



abstract class ExtraModel extends Model
{
//    use HasPermissions;
    use HasRoles;

    public static function setObject()
    {
        return "NONE";
    }

    public static function getObject()
    {
        return static::setObject(); // Здесь действует позднее статическое связывание
    }

    public function save(array $options = [])
    {

        $user = auth()->user();

        if ($user) {
            if ($user->hasPermissionTo(static::getObject().'_create')) {
                return parent::save($options);
            }
            throw new \Exception('Недостаточно прав');
        }
        throw new \Exception('Время действия вашей сессии истекло');
    }
}

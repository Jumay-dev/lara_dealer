<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    public function template()
    {
        try {
            $template = $this->hasOne('App\Model\MailTemplate', 'provider_id', 'id');
            if (empty($template)) {
                throw new \Exception('template is empty');
            }
            return $template;
        } catch (\Exception $error) {
            $template = new MailTemplate;
            $template->where('provider_id', 0); //default template
            return $template;
        }
    }
}

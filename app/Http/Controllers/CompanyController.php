<?php

namespace App\Http\Controllers;

use App\Models\Company;

class CompanyController extends Controller
{
    protected $table = 'companies';

    public static function setObject()
    {
        return "companies";
    }

    public function updateMain()
    {
        $fields = request(['id', 'name', 'phone', 'email', 'logo']);
        $company = new Company;
        $foundCompany = $company->find($fields['id']);
        foreach ($fields as $key => $value) {
            if (!empty($value)) {
                $foundCompany->$key = $value;
            }
        }
        $foundCompany->save();
    }
}

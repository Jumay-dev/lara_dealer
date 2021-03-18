<?php

namespace App\Http\Controllers;

use App\Models\Company;

class BankDetailsController extends Controller
{
    protected $table = 'bank_details';

    public static function setObject()
    {
        return "bank_details";
    }

    public function getDetails()
    {
        $company_id = \request('id');
        $company = new Company;
        $foundCompany = $company->find($company_id);
        return response()->json(
            [
                "success" => true,
                "details" => $foundCompany->companyDetals
            ]
        );
    }
}

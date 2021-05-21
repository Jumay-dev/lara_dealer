<?php

namespace App\Http\Controllers;

use App\Models\BankDetails;
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
                "details" => $foundCompany->companyDetails
            ]
        );
    }

    public function create()
    {
        $details = new BankDetails;
        $fields = request(
            [
                'company_id',
                'name',
                'shortname',
                'legal_form',
                'director',
                'address',
                'post_address',
                'phone',
                'email',
                'inn',
                'ogrn',
                'bank_details',
                'licenses'
            ]
        );
        foreach ($fields as $key => $value) {
            if (!empty($value)) {
                $details->$key = $value;
            }
        }
        $details->save();
    }
}

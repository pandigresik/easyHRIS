<?php

namespace App\Http\Requests\API\Hr;

use App\Models\Hr\Payroll;
use InfyOm\Generator\Request\APIRequest;

class UpdatePayrollAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Payroll::$rules;

        return $rules;
    }
}

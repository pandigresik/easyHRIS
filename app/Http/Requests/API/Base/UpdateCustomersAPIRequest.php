<?php

namespace App\Http\Requests\API\Base;

use App\Models\Base\Customers;
use InfyOm\Generator\Request\APIRequest;

class UpdateCustomersAPIRequest extends APIRequest
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
        $rules = Customers::$rules;

        return $rules;
    }
}

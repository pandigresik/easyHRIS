<?php

namespace App\Http\Requests\API\Base;

use App\Models\Base\Department;
use InfyOm\Generator\Request\APIRequest;

class UpdateDepartmentAPIRequest extends APIRequest
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
        $rules = Department::$rules;
        
        return $rules;
    }
}

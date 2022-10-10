<?php

namespace App\Http\Requests\API\Hr;

use App\Models\Hr\EducationalInstitute;
use InfyOm\Generator\Request\APIRequest;

class CreateEducationalInstituteAPIRequest extends APIRequest
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
        return EducationalInstitute::$rules;
    }
}

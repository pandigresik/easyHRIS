<?php

namespace App\Http\Requests\API\Hr;

use App\Models\Hr\FingerprintDevice;
use InfyOm\Generator\Request\APIRequest;

class UpdateFingerprintDeviceAPIRequest extends APIRequest
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
        $rules = FingerprintDevice::$rules;

        return $rules;
    }
}

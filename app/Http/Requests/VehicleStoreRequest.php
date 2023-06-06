<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleStoreRequest extends FormRequest
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
        return [
            'year' => [
                'required',
                'integer'
            ],
            'color' => [
                'required',
                'max:255'
            ],
            'price' => [
                'required',
                'integer'
            ],
            'stock' => [
                'required',
                'integer'
            ],
            'vehicle_type' =>[
                'required',
                'in:motorcycle,car'
            ],
            'car.machine' => [
                'required_if:vehicle_type,car',
                'max:255'
            ],
            'car.passanger_capacity' => [
                'required_if:vehicle_type,car',
                'integer'
            ],
            'car.type' => [
                'required_if:vehicle_type,car',
                'max:255'
            ],
            'motorcycle.machine' => [
                'required_if:vehicle_type,motorcycle',
                'max:255'
            ],
            'motorcycle.suspension_type' => [
                'required_if:vehicle_type,motorcycle',
                'max:255'
            ],
            'motorcycle.transmission_type' => [
                'required_if:vehicle_type,motorcycle',
                'max:255'
            ],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
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
            'symbol' => 'required',
            'side' => 'required',
            'cur_price' => 'required',
            'leverage' => 'required',
            'quantity' => 'required|numeric',
            'stop1' => 'required|numeric',
            //'stop2' => 'required|boolean',
            'take' => 'required|numeric',
            'stop1_price' => 'required|numeric',
            //'stop2_price' => 'required|numeric',
            'take_price' => 'required|numeric',
        ];
    }
}

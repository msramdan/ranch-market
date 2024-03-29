<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKelurahanRequest extends FormRequest
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
            'kecamatan_id' => 'required|exists:App\Models\Kecamatan,id',
			'kelurahan' => 'required|string|min:1|max:100',
			'kd_pos' => 'required|string|min:1|max:5',
        ];
    }
}

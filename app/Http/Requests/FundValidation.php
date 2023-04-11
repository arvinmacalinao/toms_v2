<?php

namespace App\Http\Requests;

use App\Models\Fund;
use Illuminate\Foundation\Http\FormRequest;

class FundValidation extends FormRequest
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
        $id     = intval($this->route('id'));
        $item   = NULL;
        if($id > 0) {
            $item = Fund::find($id);
        }
        return [
            'f_name'   => 'bail|required|string|min:1|max:255'
        ];
    }

    public function attributes()
    {
        return [
            'f_name'    => 'Fund Name',
        ];
    }
}

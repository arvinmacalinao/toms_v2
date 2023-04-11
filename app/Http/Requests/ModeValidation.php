<?php

namespace App\Http\Requests;

use App\Models\Mode;
use Illuminate\Foundation\Http\FormRequest;

class ModeValidation extends FormRequest
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
            $item = Mode::find($id);
        }
        return [
            'm_name'   => 'bail|required|string|min:1|max:255'
        ];
    }

    public function attributes()
    {
        return [
            'm_name'    =>  'Vehicle Mode Name'
        ];
    }
}

<?php

namespace App\Http\Requests\Backend\Access\Menu;

use App\Http\Requests\Request;

/**
 * Class StoreUserRequest
 * @package App\Http\Requests\Backend\Access\User
 */
class StoreMenuRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('create-menus');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $data=$this->all();
        return [
            'menu_name'                  => 'required',
//            'lang_key'                 => 'sometimes|required|sting|max:50',
            'url'              => 'sometimes|required|max:50',
//            'sort' => 'sometimes|required|integer',
        ];
    }
}

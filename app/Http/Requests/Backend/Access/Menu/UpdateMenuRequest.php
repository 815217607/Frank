<?php

namespace App\Http\Requests\Backend\Access\Menu;

use App\Http\Requests\Request;

/**
 * Class UpdateRoleRequest
 * @package App\Http\Requests\Backend\Access\Role
 */
class UpdateMenuRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('edit-menus');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'menu_name' => 'required',
            'url'              => 'sometimes|required|max:50',
        ];
    }
}

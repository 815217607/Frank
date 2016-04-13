<?php

namespace App\Http\Requests\Backend\Access\Menu;

use App\Http\Requests\Request;

/**
 * Class EditRoleRequest
 * @package App\Http\Requests\Backend\Access\Role
 */
class EditMenuRequest extends Request
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
            //
        ];
    }
}

<?php

namespace App\Http\Requests\Backend\Access\Menu;

use App\Http\Requests\Request;

/**
 * Class DeleteRoleRequest
 * @package App\Http\Requests\Backend\Access\Role
 */
class DeleteMenuRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('delete-menus');
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

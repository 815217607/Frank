<?php

namespace App\Services\Access\Traits;

/**
 * Class ConfirmUsers
 * @package App\Services\Access\Traits
 */
trait ConfirmUsers
{

    /**
     * Confirms the users account by their token
     *
     * @param $token
     * @return mixed
     */
    public function confirmAccount($token,$route=null)
    {

        $route=isset($route)?$route:'auth.login';
        $this->user->confirmAccount($token);
        return redirect()->route($route)->withFlashSuccess(trans('exceptions.frontend.auth.confirmation.success'));
    }

    /**
     * @param $token
     * @return mixed
     */
    public function resendConfirmationEmail($token,$route=null)
    {
        $route=isset($route)?$route:'auth.login';
        $this->user->resendConfirmationEmail($token);
        return redirect()->route($route)->withFlashSuccess(trans('exceptions.frontend.auth.confirmation.resent'));
    }
}
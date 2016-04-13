<?php
/**
 * User: fuqixue1987@163.com
 */

namespace App\Core\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * @package App\Facades
 *
 * @method static string upload()
 */
class LeanCloudService extends Facade {

    protected static function getFacadeAccessor() {
        return 'LeanCloudService';
    }

}
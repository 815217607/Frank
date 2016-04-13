<?php
/**
 * User: yang163_yang@hotmail.com
 * Date: 15/7/17
 * Time: 18:27
 */

namespace App\Core\Facades;


use Illuminate\Support\Facades\Facade;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class FileUploadService
 * @package App\Core\Facades
 *
 * @method static string upload($filePath, $ext) save upload file, return file uri
 */
class FileUploadService extends Facade {

    protected static function getFacadeAccessor() {
        return 'FileUploadService';
    }

}

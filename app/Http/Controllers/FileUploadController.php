<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Str;

/**
 * The class takes care of the file upload to the server
 * in the case the user uploads pictures of products and categories
 * and of file renaming in the case of product or category update
 * 
 * @author Marino Giudice
 */

class FileUploadController extends Controller
{
    
    /**
     * The function uploads a file to the server
     * Takes as parameters the file the path where to store it and the
     * file name 
     * 
     */

    public static function uploadFile($file, $path, $name) {
        try {
            $newFileName=Str::lower(Str::replace(' ', '_', $name));
            $newFileName=$newFileName.'.'.$file->extension();
            return $file->storeAs($path,$newFileName,'public');
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * The function renames a file
     * Takes as parameter the current name of the file
     * the new name and the name of the folder where it's stored 
     */

    public static function renameFile($namePath, $newName, $prefix) {
        $extension = pathinfo(storage_path($namePath), PATHINFO_EXTENSION);
        $imagePath=($prefix.'/').Str::lower(Str::replace(' ','_',$newName)).'.'.$extension;
        Storage::disk('public')->move($namePath, $imagePath);
        return $imagePath;
    }
}

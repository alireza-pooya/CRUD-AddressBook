<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UploadFile
{
    /**
     * @param $Form
     * @param $Data
     * @param $UploadPath
     * Upload picture and save to Uploads_dir
     */
    public function UploadFile($Form, $Data, $UploadPath)
    {
        $file = $Form['image']->getData();
        if (!is_null($file)) {
            //create new file name
            $fileName = md5(uniqid()) . '.' . $file->guessClientExtension();
            // Move the file to the directory where picture are stored
            try {
                $file->move($UploadPath, $fileName);
            } catch (FileException $e) {
                echo 'Caught exception: ', $e->getMessage(), "\n";
            }
            $Data->setPicture($fileName);
        }
    }
}
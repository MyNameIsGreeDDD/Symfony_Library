<?php


namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;


class CoverService
{

    public function uploadCover($cover, $uploadDir): string
    {
        $cover = $cover['cover']->getRealPath();
        $path = $uploadDir . 'CoverBook-' . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9);
        move_uploaded_file($cover, $path);
        $path = substr($path, -29);
        return $path;
    }

}
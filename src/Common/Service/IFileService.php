<?php

declare(strict_types=1);

namespace Common\Service;

use yii\web\UploadedFile;

interface IFileService
{
    public function uploadFile(UploadedFile $file): string;

    public function removeFile(string $filename): bool;

    public function getImagePath(string $filename): string;
}

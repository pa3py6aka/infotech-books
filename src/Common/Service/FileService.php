<?php

declare(strict_types=1);

namespace Common\Service;

use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class FileService implements IFileService
{
    public function uploadFile(UploadedFile $file): string
    {
        // todo: Здесь нужно ещё сжимать изображения и конвертировать к одному формату, есть специальные библиотеки для этого.
        $filename = uniqid('book_', true) . '.' . $file->extension;
        if ($file->saveAs($this->getImagePath($filename)) === false) {
            throw new \RuntimeException('Не удалось сохранить файл');
        }

        return $filename;
    }

    public function removeFile(string $filename): bool
    {
        return FileHelper::unlink($this->getImagePath($filename));
    }

    public function getImagePath(string $filename): string
    {
        return \Yii::getAlias('@app/storage/images/') . $filename;
    }
}

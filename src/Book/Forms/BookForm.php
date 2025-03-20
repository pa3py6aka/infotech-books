<?php

declare(strict_types=1);

namespace Book\Forms;

use yii\base\Model;
use yii\web\UploadedFile;

class BookForm extends Model
{
    public const string FIELD_TITLE = 'title';
    public const string FIELD_DESCRIPTION = 'description';
    public const string FIELD_ISBN = 'isbn';
    public const string FIELD_PUBLISHED_AT = 'published_at';
    public const string FIELD_IMAGE = 'image';

    public string $title = '';
    public string $description = '';
    public string $isbn = '';
    public string $published_at = '';
    public null|string|UploadedFile $image = '';

    public function rules(): array
    {
        return [
            [[self::FIELD_TITLE, self::FIELD_DESCRIPTION, self::FIELD_ISBN, self::FIELD_PUBLISHED_AT], 'required'],
            [self::FIELD_TITLE, 'string', 'max' => 200],
            [self::FIELD_DESCRIPTION, 'string', 'max' => 2000],
            [self::FIELD_PUBLISHED_AT, 'date', 'format' => 'php:d.m.Y'],
            [self::FIELD_ISBN, 'match', 'pattern' => '/^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$/'],
            [self::FIELD_IMAGE, 'file', 'extensions' => 'png, jpg'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            self::FIELD_TITLE => 'Название',
            self::FIELD_DESCRIPTION => 'Описание',
            self::FIELD_ISBN => 'ISBN',
            self::FIELD_PUBLISHED_AT => 'Дата публикации',
            self::FIELD_IMAGE => 'Изображение главной страницы',
        ];
    }
}

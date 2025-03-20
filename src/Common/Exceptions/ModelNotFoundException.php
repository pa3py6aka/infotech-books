<?php

declare(strict_types=1);

namespace Common\Exceptions;

class ModelNotFoundException extends \Exception
{
    public static function notFoundById(string $table_name, int $id): self
    {
        return new self(sprintf('В БД не найдена запись в таблице %s по id = %d.', $table_name, $id));
    }
}

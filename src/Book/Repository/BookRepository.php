<?php

declare(strict_types=1);

namespace Book\Repository;

use Book\Entity\Book;
use Common\Exceptions\ModelNotFoundException;
use Common\Exceptions\ModelSaveException;
use yii\db\Exception;

class BookRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Book
    {
        $book = Book::findOne($id);
        if ($book === null) {
            throw ModelNotFoundException::notFoundById(Book::tableName(), $id);
        }

        return $book;
    }

    /**
     * @throws ModelSaveException|Exception
     */
    public function save(Book $book): Book
    {
        if (!$book->validate() || !$book->save()) {
            throw new ModelSaveException('Не удалось сохранить книгу');
        }

        return $book;
    }

    public function delete(int $id): bool
    {
        // Для того чтобы сработало событие after/beforeDelete(или как они там), сначала достаём модель из БД
        // (по моему при Book::deleteAll($condition) такое событие не сработает, но могу ошибаться)
        return (bool)Book::findOne($id)?->delete();
    }
}

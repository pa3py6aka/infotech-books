<?php

declare(strict_types=1);

namespace User\Repository;

use Book\Entity\Book;
use Common\Exceptions\ModelNotFoundException;
use Common\Exceptions\ModelSaveException;
use User\Entity\User;
use yii\db\Exception;
use yii\db\StaleObjectException;

class UserRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getById(int $id): User
    {
        $user = User::findOne([User::ATTR_ID => $id]);
        if ($user === null) {
            throw ModelNotFoundException::notFoundById(User::tableName(), $id);
        }

        return $user;
    }

    public function getByEmail(string $email): ?User
    {
        return User::findOne([User::ATTR_EMAIL => $email]);
    }

    /**
     * @throws ModelSaveException|Exception
     */
    public function save(User $user): User
    {
        if (!$user->validate() || !$user->save()) {
            throw new ModelSaveException('Не удалось сохранить пользователя');
        }

        return $user;
    }

    /**
     * @return User[]
     */
    public function getTopAuthors(?string $year = null, int $limit = 10): array
    {
        $query = User::find()
            ->select([
                'users.*',
                'books_count' => 'COUNT(books.id)',
            ])
            ->joinWith(Book::tableName())
            ->groupBy('users.id')
            ->orderBy('COUNT(books.id) DESC')
            ->limit($limit);

        if ($year !== '') {
            $query->where(
                sprintf('YEAR(%s.%s) = %s', Book::tableName(), Book::ATTR_PUBLISHED_AT, $year)
            );
        }

        /** @phpstan-ignore-next-line */
        return $query->all();
    }

    /**
     * @throws ModelNotFoundException
     */
    public function addSubscription(int $user_id, int $author_id): void
    {
        $user = $this->getById($user_id);
        $author = $this->getById($author_id);
        $user->link('subscribedAuthors', $author);
    }

    /**
     * @throws ModelNotFoundException|Exception|StaleObjectException
     */
    public function removeSubscription(int $user_id, int $author_id): void
    {
        $user = $this->getById($user_id);
        $author = $this->getById($author_id);
        $user->unlink('subscribedAuthors', $author, true);
    }
}

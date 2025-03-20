<?php

declare(strict_types=1);

namespace User\Service;

use Book\Entity\Book;
use Common\Exceptions\ModelNotFoundException;
use Common\Jobs\SendSmsNotifyJob;
use User\Repository\UserRepository;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;

class SubscribeService
{
    public function __construct(private UserRepository $repository)
    {
    }

    /**
     * @throws ModelNotFoundException|Exception|StaleObjectException
     */
    public function switchAuthorSubscription(int $user_id, bool $action, int $author_id): void
    {
        $action === true
            ? $this->repository->addSubscription($user_id, $author_id)
            : $this->repository->removeSubscription($user_id, $author_id);
    }

    public function notify(Book $book): void
    {
        foreach($book->author->subscribedUsers as $user) {
            if ($user->getPhone() === '') {
                continue;
            }

            Yii::$app->queue->push(new SendSmsNotifyJob([
                'phone' => $user->getPhone(),
                'book' => $book,
            ]));
        }
    }
}

<?php

declare(strict_types=1);

namespace Common\Jobs;

use Book\Entity\Book;
use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii\queue\Queue;
use yiidreamteam\smspilot\Api;

class SendSmsNotifyJob extends BaseObject implements JobInterface
{
    public string $phone;
    public Book $book;

    public function execute(Queue $queue): void
    {
        // Использовал готовый клиент с гитхаба, но лучше свой написать, у меня времени не хватило.
        // Если надо, могу написать на выходных
        $api_provider = new Api(Yii::$app->params['sms_api_key']);
        $message = sprintf('У автора %s опубликована новая книга %s', $this->book->author->getUsername(), $this->book->title);
        $api_provider->send($this->phone, $message);
    }
}

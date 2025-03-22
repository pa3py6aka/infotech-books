<?php

declare(strict_types=1);

namespace Common\Jobs;

use Common\Api\SmsPilotClient;
use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii\queue\Queue;

class SendSmsNotifyJob extends BaseObject implements JobInterface
{
    public array $phones;

    public function execute(Queue $queue): void
    {
        Yii::$container->get(SmsPilotClient::class)->sendSMS(
            $this->phones,
            'Автор на которого вы подписаны, выпустил новую книжечку.'
        );
    }
}

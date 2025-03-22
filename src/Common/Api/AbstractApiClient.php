<?php

declare(strict_types=1);

namespace Common\Api;

use yii\httpclient\Client;
use yii\httpclient\Exception;

abstract class AbstractApiClient
{
    public function __construct(protected readonly Client $client)
    {
    }

    abstract protected function getUrl(): string;

    /**
     * @throws BadRequestException
     */
    protected function sendPost(array $data): mixed
    {
        try {
            $response = $this->client->post($this->getUrl(), $data)->send();
            if ($response->getIsOk() === false) {
                throw new BadRequestException(sprintf('Ошибка запроса %s => data: `%s`', $this->getUrl(), json_encode($data)));
            }

            return $response->getData();
        } catch (Exception $exception) {
            throw new BadRequestException(previous: $exception);
        }
    }
}

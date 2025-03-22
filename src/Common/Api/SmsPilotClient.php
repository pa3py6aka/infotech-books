<?php

declare(strict_types=1);

namespace Common\Api;

class SmsPilotClient extends AbstractApiClient
{
    private string $api_url = 'https://smspilot.ru/api2.php';

    protected function getUrl(): string
    {
        return $this->api_url;
    }

    /**
     * @throws BadRequestException
     */
    public function sendSMS(array $phones, string $message): void
    {
        $this->sendPost([
            'apikey' => $this->getApiKey(),
            'from' => 'Booker',
            'send' => [
                array_map(static fn (string $phone): array => ['to' => $phone, 'text' => $message], $phones),
            ]
        ]);
    }

    private function getApiKey(): string
    {
        return \Yii::$app->params['sms_api_key'];
    }
}

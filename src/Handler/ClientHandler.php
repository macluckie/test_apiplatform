<?php

namespace App\Handler;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Entity\Client;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;


final class ClientHandler implements MessageHandlerInterface
{
    private $clientHttp;
    private $normalizer;
    const URL_EXTERN = 'https://webhook.site/97ff8a95-59ec-4738-a985-0f8c49f1da91';

    public function __construct(HttpClientInterface $clientHttp,NormalizerInterface $normalizer )
    {
        $this->clientHttp = $clientHttp;
        $this->normalizer = $normalizer;
    }
    public function __invoke(Client $client)
    {
        $this->clientHttp->request('POST',self::URL_EXTERN,
        [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'body' => json_encode($this->normalizer->normalize($client))
        ]
    );
    }
}

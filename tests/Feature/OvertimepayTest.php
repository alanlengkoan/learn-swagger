<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use Tests\TestCase;

class OvertimepayTest extends TestCase
{
    public function test_satu()
    {
        $client = new Client([
            'base_uri' => "http://localhost:8000",
        ]);

        $headers = [
            'Content-Type'  => 'application/json',
        ];

        $body = [
            'month' => '2022/09',
        ];

        $response = $client->request('GET', '/api/overtime-pays/calculate', [
            'headers' => $headers,
            'body'    => json_encode($body),
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_dua()
    {
        $client = new Client([
            'base_uri' => "http://localhost:8000",
        ]);

        $headers = [
            'Content-Type'  => 'application/json',
        ];

        $body = [
            'month' => '2022-09',
        ];

        $response = $client->request('GET', '/api/overtime-pays/calculate', [
            'headers' => $headers,
            'body'    => json_encode($body),
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }
}

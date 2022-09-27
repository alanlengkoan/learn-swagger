<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use Tests\TestCase;

class SettingsTest extends TestCase
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
            'key'   => 'overtime_method',
            'value' => 1
        ];

        $response = $client->request('PATCH', '/api/settings', [
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
            'key'   => '',
            'value' => 1
        ];

        $response = $client->request('PATCH', '/api/settings', [
            'headers' => $headers,
            'body'    => json_encode($body),
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_tiga()
    {
        $client = new Client([
            'base_uri' => "http://localhost:8000",
        ]);

        $headers = [
            'Content-Type'  => 'application/json',
        ];

        $body = [
            'key'   => 'overtime_method',
            'value' => ''
        ];

        $response = $client->request('PATCH', '/api/settings', [
            'headers' => $headers,
            'body'    => json_encode($body),
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_empat()
    {
        $client = new Client([
            'base_uri' => "http://localhost:8000",
        ]);

        $headers = [
            'Content-Type'  => 'application/json',
        ];

        $body = [
            'key'   => '',
            'value' => ''
        ];

        $response = $client->request('PATCH', '/api/settings', [
            'headers' => $headers,
            'body'    => json_encode($body),
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }
}

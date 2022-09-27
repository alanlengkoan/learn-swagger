<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use Tests\TestCase;

class OvertimesTest extends TestCase
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
            'employee_id'  => '1',
            'date'         => '2022-01-01',
            'time_started' => '08:30',
            'time_ended'   => '17:00',
        ];

        $response = $client->request('POST', '/api/overtimes', [
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
            'employee_id'  => '0',
            'date'         => '2022-01-01',
            'time_started' => '08:30',
            'time_ended'   => '17:00',
        ];

        $response = $client->request('POST', '/api/overtimes', [
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
            'employee_id'  => '1',
            'date'         => '2022-01-02',
            'time_started' => '08:30',
            'time_ended'   => '08:29',
        ];

        $response = $client->request('POST', '/api/overtimes', [
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
            'employee_id'  => '1',
            'date'         => '2022-01-02',
            'time_started' => '08:30',
            'time_ended'   => '07:00',
        ];

        $response = $client->request('POST', '/api/overtimes', [
            'headers' => $headers,
            'body'    => json_encode($body),
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }
}

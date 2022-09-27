<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use Tests\TestCase;

class EmployeesTest extends TestCase
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
            'name'   => 'a',
            'salary' => 2000000
        ];

        $response = $client->request('POST', '/api/employees', [
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
            'name'   => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam, illum eum? Voluptatem adipisci, beatae veniam aspernatur magnam iste rerum doloribus quod, perspiciatis ducimus voluptate odit assumenda atque hic repellendus voluptates.Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam, illum eum? Voluptatem adipisci, beatae veniam aspernatur magnam iste rerum doloribus quod, perspiciatis ducimus voluptate odit assumenda atque hic repellendus voluptates.',
            'salary' => 2000000
        ];

        $response = $client->request('POST', '/api/employees', [
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
            'name'   => 1234567890,
            'salary' => 2000000
        ];

        $response = $client->request('POST', '/api/employees', [
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
            'name'   => 'alan',
            'salary' => 1000000
        ];

        $response = $client->request('POST', '/api/employees', [
            'headers' => $headers,
            'body'    => json_encode($body),
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_lima()
    {
        $client = new Client([
            'base_uri' => "http://localhost:8000",
        ]);

        $headers = [
            'Content-Type'  => 'application/json',
        ];

        $body = [
            'name'   => 'alan',
            'salary' => 11000000
        ];

        $response = $client->request('POST', '/api/employees', [
            'headers' => $headers,
            'body'    => json_encode($body),
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_enam()
    {
        $client = new Client([
            'base_uri' => "http://localhost:8000",
        ]);

        $headers = [
            'Content-Type'  => 'application/json',
        ];

        $body = [
            'name'   => 'alan',
            'salary' => 2000000
        ];

        $response = $client->request('POST', '/api/employees', [
            'headers' => $headers,
            'body'    => json_encode($body),
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_tujuh()
    {
        $client = new Client([
            'base_uri' => "http://localhost:8000",
        ]);

        $headers = [
            'Content-Type'  => 'application/json',
        ];

        $body = [
            'name'   => 'alan',
            'salary' => 3000000
        ];

        $response = $client->request('POST', '/api/employees', [
            'headers' => $headers,
            'body'    => json_encode($body),
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_delapan()
    {
        $client = new Client([
            'base_uri' => "http://localhost:8000",
        ]);

        $headers = [
            'Content-Type'  => 'application/json',
        ];

        $body = [
            'name'   => '',
            'salary' => ''
        ];

        $response = $client->request('POST', '/api/employees', [
            'headers' => $headers,
            'body'    => json_encode($body),
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }
}

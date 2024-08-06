<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testListCustomers()
    {
        $this->client->request('GET', '/customers');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $response = $this->client->getResponse()->getContent();
        $data = json_decode($response, true);

        // Validate the response structure
        $this->assertIsArray($data);
        foreach ($data as $customer) {
            $this->assertArrayHasKey('fullName', $customer);
            $this->assertArrayHasKey('email', $customer);
            $this->assertArrayHasKey('country', $customer);
            $this->assertIsString($customer['fullName']);
            $this->assertIsString($customer['email']);
            $this->assertIsString($customer['country']);
        }
    }

    public function testGetCustomerDetails()
    {
        // Assume customer with ID 1 exists
        $this->client->request('GET', '/customers/1');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $response = $this->client->getResponse()->getContent();
        $data = json_decode($response, true);

        // Validate the response structure
        $this->assertIsArray($data);
        $this->assertArrayHasKey('fullName', $data);
        $this->assertArrayHasKey('email', $data);
        $this->assertArrayHasKey('username', $data);
        $this->assertArrayHasKey('gender', $data);
        $this->assertArrayHasKey('country', $data);
        $this->assertArrayHasKey('city', $data);
        $this->assertArrayHasKey('phone', $data);
        $this->assertIsString($data['fullName']);
        $this->assertIsString($data['email']);
        $this->assertIsString($data['username']);
        $this->assertIsString($data['gender']);
        $this->assertIsString($data['country']);
        $this->assertIsString($data['city']);
        $this->assertIsString($data['phone']);
    }

    public function testGetCustomerNotFound()
    {
        $this->client->request('GET', '/customers/9999'); // Assuming 9999 does not exist

        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
        $response = $this->client->getResponse()->getContent();
        $data = json_decode($response, true);

        // Validate the error response structure
        $this->assertIsArray($data);
        $this->assertArrayHasKey('error', $data);
        $this->assertIsString($data['error']);
    }
}

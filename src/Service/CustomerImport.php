<?php

namespace App\Service;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerImport
{
    private $httpClient;
    private $entityManager;

    public function __construct(HttpClientInterface $httpClient, EntityManagerInterface $entityManager)
    {
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
    }

    public function import(): void
    {
        $response = $this->httpClient->request('GET', 'https://randomuser.me/api', [
            'query' => [
                'results' => 100,
                'nat' => 'AU'
            ]
        ]);

        $data = $response->toArray();

        foreach ($data['results'] as $userData) {
            $email = $userData['email'];

            $customer = $this->entityManager->getRepository(Customer::class)->findOneBy(['email' => $email]);

            if (!$customer) {
                $customer = new Customer();
            }

            $customer->setGender($userData['gender']);
            $customer->setName($userData['name']);
            $customer->setLocation($userData['location']);
            $customer->setEmail($userData['email']);
            $customer->setLogin($userData['login']);
            $customer->setDob($userData['dob']);
            $customer->setRegistered($userData['registered']);
            $customer->setPhone($userData['phone']);
            $customer->setCell($userData['cell']);
            $customer->setIdentification($userData['id']);
            $customer->setPicture($userData['picture']);
            $customer->setNat($userData['nat']);

            $this->entityManager->persist($customer);
        }

        $this->entityManager->flush();
    }
}
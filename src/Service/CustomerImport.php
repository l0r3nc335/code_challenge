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

            $customer->setFirstName($userData['name']['first']);
            $customer->setLastName($userData['name']['last']);
            $customer->setEmail($email);
            // Set other fields...

            $this->entityManager->persist($customer);
        }

        $this->entityManager->flush();
    }
}
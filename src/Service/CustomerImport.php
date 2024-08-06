<?php

namespace App\Service;

use App\Entity\Customer;
use App\Security\UserDataPasswordHasher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerImport
{
    private $httpClient;
    private $entityManager;
    private $userSecurity;

    public function __construct(
        HttpClientInterface    $httpClient,
        EntityManagerInterface $entityManager,
        UserDataPasswordHasher $userSecurity,
    )
    {
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
        $this->userSecurity = $userSecurity;
    }

    public function import(): void
    {
        try{
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

                $userData['login']['password'] = $this->userSecurity->setPassword($userData['login']['password']);

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
        } catch (\Exception $e) {
            // Handle exceptions (e.g., log the error, notify admin)
            throw new \RuntimeException('An error occurred while importing customers', 0, $e);
        }
    }
}
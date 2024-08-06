<?php

namespace App\Controller;

use App\Exception\CustomerNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Customer;

class ApiController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/customers', name: 'app_api', methods: ['GET'])]
    public function listCustomers(): JsonResponse
    {
        try{
            $customers = $this->entityManager->getRepository(Customer::class)->findAll();

            $data = array_map(function (Customer $customer) {
                return [
                    'fullName' => $customer->getFullName(),
                    'email' => $customer->getEmail(),
                    'country' => $customer->getCountry(),
                ];
            }, $customers);

            return new JsonResponse($data);

        } catch (\Exception $e) {
            return new JsonResponse(
                ['error' => 'An unexpected error occurred'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    #[Route('/customers/{id}', name: 'api_customer_details', methods: ['GET'])]
    public function getCustomerDetails(int $id): JsonResponse
    {
        try {
            $customerRepository = $this->entityManager->getRepository(Customer::class);
            $customer = $customerRepository->find($id);

            if (!$customer) {
                return new JsonResponse(
                    ['error' => 'Customer not found'],
                    Response::HTTP_NOT_FOUND
                );
            }

            $data = [
                'fullName' => $customer->getFullName(),
                'email' => $customer->getEmail(),
                'username' => $customer->getUsername(),
                'gender' => $customer->getGender(),
                'country' => $customer->getCountry(),
                'city' => $customer->getCity(),
                'phone' => $customer->getPhone(),
            ];

            return new JsonResponse($data);
        } catch (CustomerNotFoundException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'An unexpected error occurred'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

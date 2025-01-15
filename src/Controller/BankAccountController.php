<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/bankAccounts', name: 'bankAccount_')]
final class BankAccountController extends AbstractController

{
    private array $accountTest = [
        [
            'id' => 1,
            'accountNumber' => '123456789',
            'balance' => 1000.00,
            'currency' => 'USD'
        ],
        [
            'id' => 2,
            'accountNumber' => '987654321',
            'balance' => 2500.50,
            'currency' => 'EUR'
        ],
        [
            'id' => 3,
            'accountNumber' => '456789123',
            'balance' => 300.75,
            'currency' => 'GBP'
        ]
    ];

    ####################
    # GET /bankAccounts#
    ####################

    #[Route('/', name: 'list', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Liste des comptes en banque',
            'data' => $this->accountTest,
        ], 200);
    }

    ##########################
    # GET BY ID /bankAccounts#
    ##########################


    #[Route('/{id}', name: 'account_by_id', methods: ['GET'])]
    public function getAccountById(int $id): JsonResponse
    {
        $account = current(array_filter($this->accountTest, function ($account) use ($id) {
            return $account['id'] === $id;
        }));

        if ($account) {
            return $this->json([
                'message' => 'Compte en banque',
                'data' => $account,
            ]);
        } else {
            return $this->json([
                'message' => 'Compte en banque non trouvé',
                'code' => 404,
            ], 404);
        }
    }

    #####################
    # POST /bankAccounts#
    #####################

    #[Route('/', name: 'create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true); //Récupere les données envoyées et les transforme en tableau.

        if (isset($data['accountNumber'], $data['balance'], $data['currency'])) {
            $data['id'] = count($this->accountTest) + 1;
            $this->accountTest[] = $data;

            return $this->json([
                'message' => 'Compte en banque créé',
                'data' => $this->accountTest,
                'code' => 201,
            ], 201);
        } else {
            return $this->json([
                'message' => 'Données invalides',
                'code' => 400,
            ], 400);
        }
    }

    #######################
    # Delete /bankAccounts#
    #######################



    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $account = current(array_filter($this->accountTest, function ($account) use ($id) {
            return $account['id'] === $id;
        }));

        if ($account) {
            $key = array_search($account, $this->accountTest);
            unset($this->accountTest[$key]);

            return $this->json([
                'message' => 'Compte en banque supprimé',
                'code' => 200,
            ]);
        } else {
            return $this->json([
                'message' => 'Compte en banque non trouvé',
                'code' => 404,
            ], 404);
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PollingController extends AbstractController
{
    #[Route('/polling', name: 'polling', methods: ['GET'])]
    public function index(Request $request): Response
    {
        return $this->render('polling/polling.html.twig', [
            'companies' => [
                [
                    'name' => 'nome',
                    'growth' => 1,
                ],
                [
                    'name' => 'nome2',
                    'growth' => 2,
                ],
                [
                    'name' => 'nome3',
                    'growth' => 3,
                ]
            ]
        ]);
    }

    #[Route('/polling/data', name: 'polling_data', methods: ['GET'])]
    public function pollingData(Request $request): Response
    {
        $companies = json_decode(file_get_contents(__DIR__ . '/../Data/polling.json'), true);

        $html = '';
        foreach ($companies as $company) {
            $growth = rand(-10, 10);
            $html .=
                '<tr > 
                    <td class="px-6 py-4 whitespace-nowrap">  
                        <div class="text-sm text-blue-900">' . $company['name'] . '</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">  
                        <div class="text-sm text-blue-900">'. $growth . ' %</div>
                    </td>
                </tr>';
        }

        return new Response($html);
    }
}
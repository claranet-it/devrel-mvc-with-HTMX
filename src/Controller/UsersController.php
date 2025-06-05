<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route('/users_search', name: 'app_users_search', methods: ['GET'])]
    public function search(
        #[MapQueryParameter] ?string $search,
        Request $request
    ): Response
    {
        $users = json_decode(file_get_contents(__DIR__ . '/../Data/users.json'), true);

        if (!$request->headers->get('HX-Request')) {
            return $this->render('users/search_user.html.twig', [
                'users' => $users
            ]);
        }



            $users = array_filter($users, function ($user) use ($search) {
                return strpos($user['name'], $search) !== false || strpos($user['last_name'], $search) !== false;
            });

        return $this->buildResponse($users);
    }

    private function buildResponse($users): Response
    {
        $html = '';
        foreach ($users as $user) {
            $html .=
                '<tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-blue-900">' . $user['id'] . '</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-blue-900">' . $user['name'] . '</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-blue-900">' . $user['last_name'] . '</div>
                    </td>
                </tr>';
        }

        return new Response($html);
    }
}
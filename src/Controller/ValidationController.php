<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ValidationController extends AbstractController
{
    #[Route('/validation', name: 'app_form', methods: ['GET'])]
    public function get(): Response
    {
        return $this->render('Validation/validation.html.twig');
    }

    #[Route('/validate-email', name: 'validate_email', methods: ['POST'])]
    public function validateEmail(Request $request): Response
    {
        $email = $request->request->get('email');

        // Mock validation logic (replace with your validation logic)
        $isValid = filter_var($email, FILTER_VALIDATE_EMAIL) !== false;

        // Response for frontend
        if ($isValid) {
            return new Response('<span class="text-sm text-green-600">Email is valid!</span>');
        }
        return new Response('<span class="text-sm text-red-600">Please enter a valid email address.</span>');
    }
}
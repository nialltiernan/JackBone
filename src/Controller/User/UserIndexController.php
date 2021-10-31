<?php

namespace App\Controller\User;

use App\Form\UserDeleteType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserIndexController extends AbstractController
{
    #[Route('/users', name: 'users.index')]
    public function __invoke(UserRepository $repository): Response
    {
        $tableRows = [];

        foreach ($repository->findAll() as $user) {
            $deleteForm = $this->createForm(UserDeleteType::class, $user, [
                'action' => $this->generateUrl('users.show', ['user' => $user->getId()])
            ]);
            $tableRows[] = ['user' => $user, 'deleteForm' => $deleteForm->createView()];
        }

        return $this->render('user/index.html.twig', ['tableRows' => $tableRows]);
    }
}
<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'users.index')]
    public function index(UserRepository $repository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $repository->findAll(),
        ]);
    }

    #[Route('/users/create', name: 'users.create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, new User());
        $form->handleRequest($request);

        if ($this->shouldCreateUser($form)) {
            /** @var User $user */
            $user = $form->getData();
            $user->setCreatedAt(new DateTimeImmutable());

            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->renderForm('user/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/users/{user}', name: 'users.show')]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user
        ]);
    }

    private function shouldCreateUser(FormInterface $form): bool
    {
        return $form->isSubmitted() && $form->isValid();
    }
}

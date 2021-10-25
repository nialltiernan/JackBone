<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'users.index')]
    public function index(UserRepository $repository): Response
    {
        return $this->render('user/index.html.twig', ['users' => $repository->findAll()]);
    }

    #[Route('/users/create', name: 'users.create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, new User());
        $form->handleRequest($request);

        if ($this->isPostValid($form)) {
            /** @var User $user */
            $user = $form->getData();
            $user->setCreatedAt(new DateTimeImmutable());

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'User created');

            return $this->redirectToRoute('users.index');
        }

        return $this->renderForm('user/create.html.twig', ['form' => $form]);
    }

    #[Route('/users/{user}', name: 'users.show', methods: ['GET', 'POST'])]
    public function show(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($this->isPostValid($form)) {
            /** @var User $user */
            $user = $form->getData();

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'User updated');

            return $this->redirectToRoute('users.index');
        }

        $form->add('save', SubmitType::class, ['label' =>'Update']);

        return $this->renderForm('user/show.html.twig', ['user' => $user, 'form' => $form]);
    }

    private function isPostValid(FormInterface $form): bool
    {
        return $form->isSubmitted() && $form->isValid();
    }
}

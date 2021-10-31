<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\UserEditType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserCreateController extends AbstractController
{
    #[Route('/users/create', name: 'users.create')]
    public function __invoke(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserEditType::class, new User());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            $user->setCreatedAt(new DateTimeImmutable());

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', sprintf('User created: %s', $user->getUsername()));
            return $this->redirectToRoute('users.index');
        }

        return $this->renderForm('user/create.html.twig', ['form' => $form]);
    }
}
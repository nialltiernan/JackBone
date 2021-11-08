<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\UserDeleteType;
use App\Form\UserEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    #[Route('/users/{user}', name: 'users.show', methods: ['GET', 'POST', 'DELETE'])]
    public function __invoke(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $editForm = $this->createForm(UserEditType::class, $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            /** @var User $user */
            $user = $editForm->getData();

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', sprintf('User updated: %s', $user->getUsername()));

            return $this->redirectToRoute('users.index');
        }

        $deleteForm = $this->createForm(UserDeleteType::class, $user);
        $deleteForm->handleRequest($request);

        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            /** @var User $user */
            $user = $editForm->getData();

            $entityManager->remove($user);
            $entityManager->flush();

            $this->addFlash('danger', sprintf('User deleted: %s', $user->getUsername()));

            return $this->redirectToRoute('users.index');
        }

        $editForm->add('save', SubmitType::class, ['label' => 'Update']);

        return $this->renderForm('user/show.html.twig', [
            'user' => $user,
            'editForm' => $editForm,
            'deleteForm' => $deleteForm,
        ]);
    }
}
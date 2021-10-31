<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserDeleteType;
use App\Form\UserEditType;
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
        $tableRows = [];

        foreach ($repository->findAll() as $user) {
            $deleteForm = $this->createForm(UserDeleteType::class, $user, [
                'action' => $this->generateUrl('users.show', ['user' => $user->getId()])
            ]);
            $tableRows[] = ['user' => $user, 'deleteForm' => $deleteForm->createView()];
        }

        return $this->render('user/index.html.twig', ['tableRows' => $tableRows]);
    }

    #[Route('/users/create', name: 'users.create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserEditType::class, new User());
        $form->handleRequest($request);

        if ($this->isSubmittedRequestValid($form)) {
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

    #[Route('/users/{user}', name: 'users.show', methods: ['GET', 'POST', 'DELETE'])]
    public function show(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $editForm = $this->createForm(UserEditType::class, $user);
        $editForm->handleRequest($request);

        if ($this->isSubmittedRequestValid($editForm)) {
            /** @var User $user */
            $user = $editForm->getData();

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', sprintf('User updated: %s', $user->getUsername()));
            return $this->redirectToRoute('users.index');
        }

        $deleteForm = $this->createForm(UserDeleteType::class, $user);
        $deleteForm->handleRequest($request);

        if ($this->isSubmittedRequestValid($deleteForm)) {
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

    private function isSubmittedRequestValid(FormInterface $form): bool
    {
        return $form->isSubmitted() && $form->isValid();
    }
}

<?php

namespace App\Controller\Emoji;

use App\Repository\EmojiCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function __invoke(EmojiCategoryRepository $repo): Response
    {
        return $this->render('emoji/index.html.twig', ['categories' => $repo->findAll()]);
    }
}
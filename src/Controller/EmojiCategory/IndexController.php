<?php

namespace App\Controller\EmojiCategory;

use App\Repository\EmojiCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/emoji-categories', name: 'emoji-categories.index')]
    public function __invoke(EmojiCategoryRepository $repo): Response
    {
        return $this->render('emoji-category/index.html.twig', ['categories' => $repo->findAll()]);
    }
}
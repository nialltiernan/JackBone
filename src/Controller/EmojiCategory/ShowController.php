<?php

namespace App\Controller\EmojiCategory;

use App\Entity\EmojiCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    #[Route('/emoji-categories/{category}', name: 'emoji-categories.show')]
    public function __invoke(EmojiCategory $category): Response
    {
        return $this->render('emoji-category/show.html.twig', ['category' => $category]);
    }
}
<?php

namespace App\Controller\Emoji;

use App\Repository\EmojiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/emojis', name: 'emojis.index')]
    public function __invoke(EmojiRepository $repo): Response
    {
        return $this->render('emoji/index.html.twig', ['emojis' => $repo->findAll()]);
    }
}
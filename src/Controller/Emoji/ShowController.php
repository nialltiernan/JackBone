<?php

namespace App\Controller\Emoji;

use App\Entity\Emoji;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    #[Route('/emoji/{emoji}', name: 'emojis.show')]
    public function __invoke(Emoji $emoji): Response
    {
        return $this->render('emoji/show.html.twig', ['emoji' => $emoji]);
    }
}
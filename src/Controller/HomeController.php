<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function home(): Response
    {
        $blogPosts = BlogController::POSTS;
        uasort($blogPosts, function (array $a, array $b) {
            return $b['date'] <=> $a['date'];
        });

        return $this->render('home.html.twig', [
            'blogPosts' => $blogPosts
        ]);
    }
}
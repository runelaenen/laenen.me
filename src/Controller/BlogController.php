<?php declare(strict_types=1);

namespace App\Controller;

use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    public const POSTS = [
        'digital-publishing-for-shopware-6' => [
            'type' => 'twig',
            'date' => '2020-10-18',
            'title' => 'Advanced Banners for Shopware 6',
            'cover' => [
                'image' => '/img/blog/advanced-banners-banner.png',
                'alt' => 'Advanced Banners (Digital Publishing) for Shopware 6'
            ],
            'template' => 'blog/2020-10-18-digital-publishing-for-shopware-6.html.twig'
        ],
        'github-actions-shopware-plugin-zip' => [
            'type' => 'twig',
            'date' => '2020-10-23',
            'title' => 'Use Github Actions to compile & release SW6 plugins',
            'cover' => [
                'image' => '/img/blog/github-actions-banner.jpg',
                'alt' => 'Use Github Actions to compile & release SW6 plugins'
            ],
            'template' => 'blog/2020-10-23-github-actions-shopware-plugin-zip.html.twig'
        ],
        'io-de-technische-troeven-van-shopware-als-e-commerceplatform' => [
            'type' => 'external',
            'date' => '2020-11-08',
            'title' => 'De technische troeven van Shopware als e-commerceplatform',
            'language' => 'NL',
            'cover' => [
                'image' => '/img/blog/blog-shopware-technisch-header.jpg',
                'alt' => 'De technische troeven van Shopware als e-commerceplatform'
            ],
            'link' => 'https://www.intracto.com/nl-be/blog/de-technische-troeven-van-shopware-als-e-commerceplatform'
        ],
        'io-makkelijker-verkopen-op-social-media-met-shopware-6' => [
            'type' => 'external',
            'date' => '2020-11-13',
            'title' => 'Makkelijker verkopen op social media met Shopware 6',
            'language' => 'NL',
            'cover' => [
                'image' => '/img/blog/blog-social-shopping-header.jpg',
                'alt' => 'Makkelijker verkopen op social media met Shopware 6'
            ],
            'link' => 'https://www.intracto.com/nl-be/blog/makkelijker-verkopen-op-social-media-met-shopware-6'
        ],
        'io-betere-klantervaringen-dankzij-shopping-experiences-van-shopware' => [
            'type' => 'external',
            'date' => '2020-12-01',
            'title' => 'Betere klantervaringen dankzij Shopping Experiences',
            'language' => 'NL',
            'cover' => [
                'image' => '/img/blog/blog-shopware-shopping-experiences-header.jpg',
                'alt' => 'Betere klantervaringen dankzij Shopping Experiences van Shopware'
            ],
            'link' => 'https://www.intracto.com/nl-be/blog/betere-klantervaringen-dankzij-shopping-experiences-van-shopware'
        ],
        'io-de-kracht-van-de-shopware-6-rule-builder' => [
            'type' => 'external',
            'date' => '2020-12-17',
            'title' => 'De kracht van de Rule Builder',
            'language' => 'NL',
            'cover' => [
                'image' => '/img/blog/blog-shopware-6-rule-builder-header.jpg',
                'alt' => 'De kracht van de Shopware 6 Rule Builder'
            ],
            'link' => 'https://www.intracto.com/nl-be/blog/de-kracht-van-de-shopware-6-rule-builder'
        ],
        'io-6-redenen-om-voor-shopware-6-te-kiezen' => [
            'type' => 'external',
            'date' => '2020-12-17',
            'title' => '6 redenen om voor Shopware 6 te kiezen',
            'language' => 'NL',
            'cover' => [
                'image' => '/img/blog/blog-shopware-6-header.jpg',
                'alt' => '6 redenen om voor Shopware 6 te kiezen'
            ],
            'link' => 'https://www.intracto.com/nl-be/blog/6-redenen-om-voor-shopware-6-te-kiezen'
        ],
        'custom-icons-in-sw6-admin' => [
            'type' => 'twig',
            'date' => '2021-05-24',
            'title' => 'Custom icons in Shopware 6 Administration',
            'cover' => [
                'image' => '/img/blog/blog-shopware-6-custom-icons-header.jpg',
                'alt' => 'Custom icons in Shopware 6 Administration',
            ],
            'template' => 'blog/2021-05-24-custom-icons-in-sw6-admin.html.twig'
        ],
    ];

    /**
     * @Route("/blog/{slug}")
     */
    public function blogPost(string $slug): Response
    {
        if (!array_key_exists($slug, self::POSTS)) {
            throw $this->createNotFoundException();
        }

        $post = self::POSTS[$slug];

        if ($post['type'] === 'md') {
            $post['content'] = file_get_contents('../' . $post['file']);

            return $this->render('blog-post-md.html.twig', [
                'post' => $post
            ]);
        }

        if ($post['type'] === 'external') {
            return $this->redirect($post['link']);
        }

        return $this->render($post['template'], [
            'post' => $post
        ]);
    }
}
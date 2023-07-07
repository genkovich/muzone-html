<?php
declare(strict_types=1);


namespace Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

final class SitemapController extends AbstractController
{

    #[Route('/sitemap', name: 'sitemap_html')]
    public function sitemapHtml(): Response
    {
        return $this->render('sitemap/sitemap.html.twig');
    }

    #[Route('/sitemap.xml', name: 'sitemap_xml')]
    public function sitemapXml(): Response
    {

        $response = new Response(
            $this->renderView('sitemap/sitemap.xml.twig'),
            200
        );

        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }

    #[Route('/sitemap_uk.xml', name: 'sitemap_uk_xml')]
    public function sitemapUkXml(): Response
    {
        $response = new Response(
            $this->renderView('sitemap/sitemap_uk.xml.twig'),
            200
        );
        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }

    #[Route('/robots.txt', name: 'robots')]
    public function robots(): Response
    {
        $response = new Response(
            $this->renderView('sitemap/robots.txt.twig'),
            200
        );
        $response->headers->set('Content-Type', 'text/plain');

        return $response;
    }
}
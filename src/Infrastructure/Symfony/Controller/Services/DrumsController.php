<?php
declare(strict_types=1);


namespace Infrastructure\Symfony\Controller\Services;

use Domain\Direction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class DrumsController extends AbstractController
{
    public function __invoke(): Response
    {
        $menu = [
            [
                'url' => '#hero',
                'title' => 'Головна',
            ],
            [
                'url' => '#cost',
                'title' => 'Про школу',
            ],
            [
                'url' => '#gift',
                'title' => 'Навчаємо',
            ],
            [
                'url' => '#reviews',
                'title' => 'Наші викладачі',
            ],
            [
                'url' => '#contacts',
                'title' => 'Зв`язатися'
            ],
        ];


        return $this->render('pages/services/drums/drums.html.twig', [
            'menu' => $menu,
        ]);
    }
}
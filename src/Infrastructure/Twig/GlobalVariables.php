<?php
declare(strict_types=1);

namespace Infrastructure\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

final class GlobalVariables extends AbstractExtension implements GlobalsInterface
{
    public function getGlobals(): array
    {
        return [
            'images' => 'window.images',
        ];
    }
}
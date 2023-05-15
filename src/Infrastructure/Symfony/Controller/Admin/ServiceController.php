<?php
declare(strict_types=1);


namespace Infrastructure\Symfony\Controller\Admin;

use Application\Admin\Service\ServiceCreateCommand;
use Application\Admin\Service\ServiceCreateHandler;
use Domain\Age;
use Domain\Common\Currency;
use Domain\Direction;
use Infrastructure\Persistence\Psql\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ServiceController extends AbstractController
{
    public function __construct(
        private readonly ServiceRepository $serviceRepository,
        private readonly ServiceCreateHandler $serviceCreateHandler,
    )
    {
    }

    public function list(): Response
    {
        $services = $this->serviceRepository->list(10, 0);
        $directions = array_map(static fn (Direction $direction) =>
            [
                'value' => $direction->value,
                'icon' => $direction->icon(),
                'label' => ucfirst($direction->value),
            ], Direction::cases());

        $currencies = array_map(static fn (Currency $currency) => $currency->value, Currency::cases());

        $ages = array_map(static fn (Age $age) =>
            [
                'value' => $age->value,
                'icon' => $age->icon(),
                'label' => ucfirst($age->value),
            ], Age::cases());

        return $this->render('admin/service/list.html.twig', [
            'services' => $services,
            'directions' => $directions,
            'currencies' => $currencies,
            'ages' => $ages,
            'offset' => 0,
        ]);
    }

    public function create(ServiceCreateCommand $serviceCreateCommand): Response
    {
        $this->serviceCreateHandler->handle($serviceCreateCommand);

        return new JsonResponse(['success' => true]);
    }

}
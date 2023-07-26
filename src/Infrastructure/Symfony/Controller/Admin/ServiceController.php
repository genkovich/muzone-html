<?php
declare(strict_types=1);


namespace Infrastructure\Symfony\Controller\Admin;

use Domain\Age;
use Domain\Common\Currency;
use Domain\Direction;
use Domain\Service\LessonsCount;
use Domain\Service\Price;
use Domain\Service\Service;
use Domain\Service\ServiceFactory;
use Domain\Service\ServiceId;
use Domain\Service\ServiceRepositoryInterface;
use Domain\Service\Title;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ServiceController extends AbstractController
{

    public function __construct(
        private readonly ServiceRepositoryInterface $serviceRepository,
    )
    {
    }

    public function list(Request $request): Response
    {
        $filter = [];

        if ($request->get('direction')) {
            $filter['direction'] = $request->get('direction');
        }

        $services = $this->serviceRepository->list(100, 0, $filter);

        return $this->render('admin/service/list.html.twig', [
            'active_direction' => $request->get('direction'),
            'services' => $services,
            'ages' => Age::all(),
            'directions' => Direction::all(),
        ]);
    }

    public function single(Request $request): Response
    {

        $serviceId = new ServiceId($request->get('service_id'));
        $service = $this->serviceRepository->find($serviceId);
        $servicePrices = $this->serviceRepository->servicePrices($serviceId);

        return $this->render('admin/service/single.html.twig', [
            'service' => $service,
            'prices' => $servicePrices,
            'ages' => Age::all(),
            'directions' => Direction::all(),
        ]);

    }

    public function create(Request $request): Response
    {

        $now = new \DateTimeImmutable();

        $serviceId = $this->serviceRepository->nextIdentity();
        $service = new Service(
            $serviceId,
            new Title($request->get('title')),
            new Price($request->get('price'), Currency::UAH),
            Direction::from($request->get('direction')),
            new LessonsCount((int)$request->get('lessons')),
            Age::from($request->get('age')),
            $now,
            $now,
        );

        $this->serviceRepository->add($service);

        return new JsonResponse(
            [
                'status' => 'success',
                'service_id' => $serviceId,
            ],
            Response::HTTP_CREATED
        );
    }

}
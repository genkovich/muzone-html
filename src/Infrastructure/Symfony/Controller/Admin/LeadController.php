<?php
declare(strict_types=1);


namespace Infrastructure\Symfony\Controller\Admin;

use Domain\Lead\LeadRepositoryInterface;
use Infrastructure\Symfony\Form\Admin\Lead\LeadListFormType;
use Infrastructure\Symfony\Form\Admin\Lead\LeadPaginationList;
use Infrastructure\Symfony\Form\BaseListPagination\ListFormType;
use Infrastructure\Symfony\Form\BaseListPagination\ListPagination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final  class LeadController extends AbstractController
{

    public function __construct(
        private readonly LeadRepositoryInterface $leadRepository,
    )
    {
    }

    public function list(Request $request): Response
    {

        $listPagination = new LeadPaginationList();
        $listPagination->setFromDate((new \DateTimeImmutable('-7 days'))->setTime(0, 0, 0));
        $listPagination->setToDate((new \DateTimeImmutable())->setTime(23, 59, 59));
        $listPagination->setLimit(25);

        $form = $this->createForm(LeadListFormType::class, $listPagination);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var LeadPaginationList $listPagination */
            $listPagination = $form->getData();
        }

        $filters = [
            'date_from' => $listPagination->getFromDate()?->setTime(0, 0, 0),
            'date_to' => $listPagination->getToDate()?->setTime(23, 59, 59),
            'search' => $listPagination->getSearch(),
        ];

        $limit = $listPagination->getLimit();
        $offset = $listPagination->getOffset();

        $leads = $this->leadRepository->getList($limit, $offset, $filters);

        $form = $this->createForm(
            LeadListFormType::class,
            $listPagination,
            [
                'has_next' => \count($leads) >= $listPagination->getLimit(),
                'has_prev' => $listPagination->getOffset() > 0,
            ]
        );

        return $this->render('admin/lead/list.html.twig', [
            'leads' => $leads,
            'form' => $form->createView(),
            'limit' => $limit,
            'offset' => $offset,
        ]);
    }
}
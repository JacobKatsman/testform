<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Form\Type\ShopType;
use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;


class TestController extends AbstractController
{
    public const TAXVAL =  [ 'DE' => 19, 'IT' => 22, 'GR' => 24];

    public function calculateProcent(array $data): int
    {
        return $data['productPrice']
               + ($data['productPrice'] / 100)
               *  self::TAXVAL[mb_substr($data['taxnumber'], 0, 2)];
    }

    public function getFormRequest(Request $request, ValidatorInterface $validator): Response
    {
        $data = $request->request->all();

        $orderRequest = new Order();
        $orderRequest->setProductPrice($data['shop']['productPrice']);
        $orderRequest->setTaxnumber($data['shop']['taxnumber']);
        $violations = $validator->validate($orderRequest);

        $accessor = PropertyAccess::createPropertyAccessor();
        $messages = [];
        $summ=0;
        if (0 === count($violations)) {
            $summ = $this->calculateProcent($data['shop']); // подсчет суммы
        } else {
            foreach ($violations as $violation) {
                 $accessor->setValue($messages,
                                     '['.$violation->getPropertyPath().']',
                                     $violation->getMessage());
            }
        }

        $noteForm = $this->createForm(
            ShopType::class,
            $orderRequest,
            [
                'action' => "/getform/",
                'method' => 'POST'
            ]
        );

        return $this->render('test.html.twig', [
            'testform' => $noteForm->createView(),
            'errors'    => $messages,
            'taxnumber' => $data['shop']['taxnumber'],
            'summ'      => $summ
        ]);
    }

    public function index(Request $request): Response
    {
        $noteForm = $this->createForm(
            ShopType::class,
            new Order(),
            [
                'action' => "/getform/",
                'method' => 'POST'
            ]
        );

        return $this->render('test.html.twig', [
            'testform' => $noteForm->createView(),
            'errors'    => '',
            'taxnumber' => '',
            'summ'     => 0
        ]);
    }
}

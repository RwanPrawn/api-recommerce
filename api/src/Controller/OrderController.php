<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Brand;
use App\Entity\Product;
use App\Entity\Order;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

class OrderController extends AbstractController
{
    /**
     * List the orders
     * 
     * @Route("/api/orders", methods={"GET"}, defaults={"_format": "json"})
     * @SWG\Response(
     *      response=200,
     *      description="Return a list of orders",
     *      @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type=Order::class))
     *      )
     * )
     */
    public function fetchOrdersAction(): JsonResponse
    {
        $orders = $this->getDoctrine()
            ->getRepository(Order::class)
            ->findAll();

        return $this->json($orders);
    }

    /**
     * get a specific order
     * 
     * @Route("/api/orders/{id}", methods={"GET"}, defaults={"_format": "json"})
     * @SWG\Response(
     *      response=200,
     *      description="Return a specific order",
     *      @Model(type=Product::class)
     * )
     */
    public function fetchOrderAction(int $id): JsonResponse
    {
        $order = $this->getDoctrine()
            ->getRepository(Order::class)
            ->findOneById($id);

        return $this->json($order);
    }
    
}
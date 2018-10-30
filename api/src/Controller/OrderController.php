<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Order;
use App\Entity\Product;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     *      @Model(type=Order::class)
     * )
     * @SWG\Response(
     *      response=404,
     *      description="Order not found"
     * )
     */
    public function fetchOrderAction(int $id): JsonResponse
    {
        $order = $this->getDoctrine()
            ->getRepository(Order::class)
            ->findOneById($id)
        ;

        if ($order) {
            return $this->json($order);
        }

        return new JsonResponse("Order not found", Response::HTTP_NOT_FOUND);
        
    }

    /**
     * post an order
     * 
     * @Route("/api/orders", methods={"POST"}, defaults={"_format": "json"})
     * @SWG\Post(
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          type="json",
     *          required=true,
     *          description="json order object",
     *          @SWG\Schema(
     *              @SWG\Property(
     *                  property="customerEmail",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="mobiles",
     *                  type="array",
     *                  @SWG\Items(
     *                      type="object",
     *                          @SWG\Property(
     *                              property="id",
     *                              type="integer"
     *                          )
     *                  )
     *              )
     *          )
     *      )
     * )
     * @SWG\Response(
     *      response=201,
     *      description="Create a new order",
     *      @Model(type=Order::class)
     * )
     * 
     * @SWG\Response(
     *      response=404,
     *      description="Product not found",
     *      @Model(type=Order::class)
     * )
     */
    public function postOrderAction(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $order = new Order($data['customerEmail']);

        $mobiles = $data['mobiles'];
        $productsRepository = $this->getDoctrine()->getRepository(Product::class);

        foreach ($mobiles as $mobile) {
            $product = $productsRepository->findOneById($mobile['id']);

            if (!$product) {
                return new JsonResponse("Product does not exist", Response::HTTP_NOT_FOUND);
            }

            $order->addMobile($product);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($order);
        $entityManager->flush();

        return new JsonResponse($order, Response::HTTP_CREATED);
    }
}
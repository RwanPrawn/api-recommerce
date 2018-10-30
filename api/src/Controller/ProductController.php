<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Product;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * List the products
     * 
     * @Route("/api/products", methods={"GET"}, defaults={"_format": "json"})
     * @SWG\Response(
     *      response=200,
     *      description="Return a list of products",
     *      @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type=Product::class))
     *      )
     * )
     */
    public function fetchProductsAction(): JsonResponse
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        return $this->json($products);
    }

    /**
     * get a specific product
     * 
     * @Route("/api/products/{id}", methods={"GET"}, defaults={"_format": "json"})
     * @SWG\Response(
     *      response=200,
     *      description="Return a specific product",
     *      @Model(type=Product::class)
     * )
     * @SWG\Response(
     *      response=404,
     *      description="Product not found"
     * )
     */
    public function fetchProductAction(int $id): JsonResponse
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findOneById($id)
        ;

        if ($product) {
            return $this->json($product);
        }

        return new JsonResponse("Product not found", Response::HTTP_NOT_FOUND);
    }
    
}
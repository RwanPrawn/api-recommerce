<?php

namespace App\Controller;

use App\Entity\Brand;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BrandController extends AbstractController
{
    /**
     * Default
     * 
     * @Route("/api")
     */
    public function defaultAction(): Response
    {
        return $this->render('base.html.twig');
    }

    /**
     * List the brands
     * 
     * @Route("/api/brands", methods={"GET"}, defaults={"_format": "json"})
     * @SWG\Response(
     *      response=200,
     *      description="Return a list of brands",
     *      @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type=Brand::class))
     *      )
     * )
     */
    public function fetchBrandsAction(): JsonResponse
    {
        $brands = $this->getDoctrine()
            ->getRepository(Brand::class)
            ->findAll();

        return $this->json($brands);
    }

    /**
     * get a specific brand
     * 
     * @Route("/api/brands/{id}", methods={"GET"}, defaults={"_format": "json"})
     * @SWG\Response(
     *      response=200,
     *      description="Return a specific brand",
     *      @Model(type=Brand::class)
     * )
     * @SWG\Response(
     *      response=404,
     *      description="Brand not found"
     * )
     */
    public function fetchBrandAction(int $id): JsonResponse
    {
        $brand = $this->getDoctrine()
            ->getRepository(Brand::class)
            ->findOneById($id);

        if ($brand) {
            return $this->json($brand);
        }

        return new JsonResponse('Brand not found', Response::HTTP_NOT_FOUND);
    }
    
}
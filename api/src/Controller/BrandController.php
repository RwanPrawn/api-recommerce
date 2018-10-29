<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Brand;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

class BrandController extends AbstractController
{
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
     */
    public function fetchBrandAction(int $id): JsonResponse
    {
        $brand = $this->getDoctrine()
            ->getRepository(Brand::class)
            ->findOneById($id);

        return $this->json($brand);
    }
    
}
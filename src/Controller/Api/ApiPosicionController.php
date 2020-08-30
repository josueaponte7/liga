<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Posicion;

/**
 * @Route("/api/v1")
 */
class ApiPosicionController extends AbstractController
{
    /**
     * @Route("/posicion/create", name="api_posicion_create", methods={"POST"})
     */
    public function api()
    {
        
        return $this->json([
            'message' => 'create new posicion'
        ]);
    }
    /**
     * @Route("/posicion/all", name="api_posicion_all", methods={"GET"})
     */
    public function list()
    {
       $em = $this->getDoctrine()->getManager();
       $repositorio = $em->getRepository(Posicion::class);
       $posiciones = $repositorio->findAll();
       
        return $this->json([
            'Posiciones' => $posiciones
        ]);
    }
}

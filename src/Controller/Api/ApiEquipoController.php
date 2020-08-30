<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1")
 */
class ApiEquipoController extends AbstractController
{
    /**
     * @Route("/equipo/create", name="api_equipo_create", methods={"POST"})
     */
    public function api()
    {
        return $this->json([
            'message' => 'create new equipo'
        ]);
    }
    /**
     * @Route("/equipo/all", name="api_equipo_all", methods={"GET"})
     */
    public function list()
    {

        return $this->json([
            'list' => 'listar equipo'
        ]);
    }
}

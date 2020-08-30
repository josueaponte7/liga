<?php

namespace App\Controller\Api;

use App\Entity\Posicion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Jugador;
use App\Entity\Equipo;

use App\Service\ExternoService;

/**
 * @Route("/api/v1")
 */
class ApiPosicionController extends AbstractController
{
    /**
     * @Route("/posicion/create", name="api_posicion_create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $nombre = $request->get('nombre');
        $response = ['codigo' => 404, 'msg' => 'Nombre no enviado'];
        if (isset($nombre)) {
            $em = $this->getDoctrine()->getManager();
            $equipo = new Posicion();
            $equipo->setNombre($nombre);
            $em->persist($equipo);
            $em->flush();
            $response = ['codigo' => 202, 'msg' => 'Posicion Creada Correctamente', 'id' => $equipo->getId()];
        }
        return $this->json($response);
    }

    /**
     * @Route("/posicion/all", name="api_posicion_all", methods={"GET"})
     */
    public function list_posicion()
    {
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Posicion::class);
        $posicion = $repositorio->findAll();

        $response = ['codigo' => 404, 'msg' => 'No existen Posiciones Registradas'];
        if ($posicion) {
            $response = ['codigo' => 200, 'listado' => $posicion];
        }
        return $this->json($response);
    }

    /**use App\Entity\Jugador;
     * @Route("/posicion/find/{id}", name="api_posicion_find", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function find($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Posicion::class);
        $posicion = $repositorio->find($id);

        $response = ['codigo' => 404, 'msg' => 'Posicion no Encontrado'];
        if ($posicion) {
            $response = ['codigo' => 200, 'posicion' => $posicion];
        }
        return $this->json($response);
    }

    /**
     * @Route("/posicion/edit/{id}", name="api_posicion_edit", requirements={"id"="\d+"}, methods={"PUT"})
     */
    public function edit($id, Request $request)
    {
        $nombre = $request->get('nombre');
        $response = ['codigo' => 404, 'msg' => 'Nombre no enviado'];
        if (isset($nombre)) {
            $em = $this->getDoctrine()->getManager();
            $repositorio = $em->getRepository(Posicion::class);

            $posicion = $repositorio->find($id);

            $response = ['codigo' => 404, 'msg' => 'Posicion no Encontrado'];
            if ($posicion) {

                $posicion->setNombre($nombre);
                $em->persist($posicion);
                $em->flush();

                $response = ['codigo' => 200, 'msg' => 'Posicion Actualizado Corectamente'];
            }
        }
        return $this->json($response);
    }

    /**
     * @Route("/posicion/delete/{id}", name="api_posicion_delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Posicion::class);
        $posicio = $repositorio->find($id);

        $response = ['codigo' => 404, 'msg' => 'Posicion no Encontrado'];
        if ($posicio) {

            $em->remove($posicio);
            $em->flush();

            $response = ['codigo' => 200, 'msg' => 'Posicion Eliminada Corectamente!!'];
        }
        return $this->json($response);
    }



    /**
     * @Route("/jugador/find/{id}/{money}", name="api_jugador_find", requirements={"id"="\d+"}, defaults={"money": "EUR"}, methods={"GET"})
     */
    public function findJ(int $id, string $money)
    {
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Jugador::class);
        $requipo = $em->getRepository(Equipo::class);
        $rposicion = $em->getRepository(Posicion::class);
        $jugador = $repositorio->find($id);
        $response = ['codigo' => 404, 'msg' => 'Jugador no Encontrado'];
        if ($jugador) {

            

            $equipo = $requipo->find($jugador->getEquipoId());
            $posicion = $rposicion->find($jugador->getPosicionId());
            $moneda = '€';
            $precio = $jugador->getPrecio();
            if($money !== 'EUR') {
                $moneda = '$';
                $service = new ExternoService();
                $precio = $service->getMoney($precio);
            }
            $data['nombre'] = $jugador->getNombre();
            $data['precio'] = $precio.' '.$moneda;
            $data['equipo']['id'] = $equipo->getId();
            $data['equipo']['equipo'] = $equipo->getNombre();
            $data['posicion']['id'] = $posicion->getId();
            $data['posicion']['posicion'] = $posicion->getNombre();
            $response = ['codigo' => 200, 'jugador' => $data];
        }
        return $this->json($response);
    }

}

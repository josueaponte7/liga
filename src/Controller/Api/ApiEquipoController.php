<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Equipo;
/**
 * @Route("/api/v1")
 */
class ApiEquipoController extends AbstractController
{
    /**
     * @Route("/equipo/create", name="api_equipo_create", methods={"POST"})
     */
    public function create(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $nombre = $request->get('nombre');

        $equipo_new = new Equipo();
        $equipo_new->setNombre($nombre);
        $em->persist($equipo_new);
        $em->flush();
        
        return $this->json([
            'message' => "Nuevo Equipo Creado:  $nombre"
        ]);
    }
    /**
     * @Route("/equipo/all", name="api_equipo_all", methods={"GET"})
     */
    public function list_equipo()
    {
       $em = $this->getDoctrine()->getManager();
       $repositorio = $em->getRepository(Equipo::class);
       $equipos = $repositorio->findAll();
       
       
       $response = ['codigo' => 404, 'msg' => 'No existen Equipos Registrados'];
       if($equipos) {
            $response = ['codigo' => 200, 'listado' => $equipos];
       }
       return $this->json($response);
    }
    
    /**
     * @Route("/equipo/find/{id}", name="api_equipo_find", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function find($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Equipo::class);
        $equipo = $repositorio->find($id);

        $response = ['codigo' => 404, 'msg' => 'Equipo no Encontrado'];
        if ($equipo) {
            $response = ['codigo' => 200, 'equipo' => $equipo];
        }
        return $this->json($response);
    }
        
     /**
     * @Route("/equipo/edit/{id}", name="api_equipo_edit", methods={"PUT"})
     */
    public function edit($id, Request $request)
    {   
        $nombre = $request->get('nombre');
        $response = ['codigo' => 404, 'msg' => 'Nombre no enviado'];
            if(isset($nombre)){
                $em = $this->getDoctrine()->getManager();
                $repositorio = $em->getRepository(Equipo::class);

                $equipo = $repositorio->find($id);

                $response = ['codigo' => 404, 'msg' => 'Equipo no Encontrado'];
            if($equipo) {

                 $equipo->setNombre($nombre);
                 $em->persist($equipo);
                 $em->flush();

                 $response = ['codigo' => 200, 'msg' => 'Equipo Actualizado Corectamente'];
            }
        }
        return $this->json($response);
    }
    

    
     /**
     * @Route("/equipo/delete/{id}", name="api_equipo_delete", methods={"DELETE"})
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Equipo::class);
        $equipo = $repositorio->find($id);

        $response = ['codigo' => 404, 'msg' => 'Equipo no Encontrado'];
        if($equipo) {

             $em->remove($equipo);
             $em->flush();

             $response = ['codigo' => 200, 'msg' => 'Equipo Eliminado Corectamente!!'];
        }
        return $this->json($response);
    }
    
    
    
    
}

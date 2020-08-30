<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Posicion;

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

        $em = $this->getDoctrine()->getManager();
        $nombre = $request->get('nombre');

        $posicion_new = new Posicion();
        $posicion_new->setNombre($nombre);
        $em->persist($posicion_new);
        $em->flush();
        
        return $this->json([
            'message' => "Nueva Posicion Creada:  $nombre"
        ]);
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
       if($posicion) {
            $response = ['codigo' => 200, 'listado' => $posicion];
       }
       return $this->json($response);
    }
    
    
    
    /**
     * @Route("/posicion/edit/{id}", name="api_posicion_edit", methods={"POST"})
     */
    public function edit($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Posicion::class);
       
        $nombre = $request->get('nombre');
        
        $posicion_all = $repositorio->find($id);
        
        $mensaje = "Posicion Actualizada Corectamente!!";
        if(!empty($posicion_all)){

            $posicion_all->setNombre($nombre);
            $em->persist($posicion_all);
            $em->flush();
        
            $mensaje =$mensaje;
             
        }else{
            $mensaje='Posicion no Encontrada';
        }
 
       
        return $this->json([
            'message' => $mensaje
        ]);
    }
    
    
    /**
     * @Route("/posicion/delete/{id}", name="api_posicion_delete", methods={"GET"})
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Posicion::class);
        
        $posicion = $repositorio->find($id);
        
        $mensaje = "Posicion Eliminada Corectamente!!";
        if(!empty($posicion)){
            
             $em->remove($posicion);
             $em->flush();
             $mensaje =$mensaje;
             
        }else{
            $mensaje='Posicion no Encontrada';
        }
 
       
        return $this->json([
            'message' => $mensaje
        ]);
    }
    
    
    
}

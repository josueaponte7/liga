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
       
       
       $mensaje='No existen Posiciones Registradas';
       
        if(!empty($equipo)){
            
            $mensaje =$mensaje;
            
        }else{
            
            $mensaje =$equipos;
            
        }
       
       
        return $this->json([
            'lista' => $equipos
        ]);
    }
    
    
        
     /**
     * @Route("/equipo/edit/{id}", name="api_equipo_edit", methods={"POST"})
     */
    public function edit($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Equipo::class);
       
        $nombre = $request->get('nombre');
        
        $equipo = $repositorio->find($id);
        
        $mensaje = "Equipo Actualizado Corectamente!!";
        if(!empty($equipo)){
            
            $equipo = $repositorio->find($id);
            $equipo->setNombre($nombre);
            $em->persist($equipo);
            $em->flush();
        
            $mensaje =$mensaje;
             
        }else{
            $mensaje='Equipo no Encontrado';
        }
 
       
        return $this->json([
            'message' => $mensaje
        ]);
    }
    

    
     /**
     * @Route("/equipo/delete/{id}", name="api_equipo_delete", methods={"GET"})
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Equipo::class);
       
        $equipo = $repositorio->find($id);
        
        $mensaje = "Equipo Eliminado Corectamente!!";
        if(!empty($equipo)){
            
             $em->remove($equipo);
             $em->flush();
             $mensaje =$mensaje;
             
        }else{
            $mensaje='Equipo no Encontrado';
        }
 
       
        return $this->json([
            'message' => $mensaje
        ]);
    }
}

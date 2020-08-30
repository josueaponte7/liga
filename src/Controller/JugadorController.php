<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Jugador;
use App\Entity\Equipo;
use App\Entity\Posicion;

class JugadorController extends AbstractController
{
    /**
     * @Route("/jugador", name="jugador")
     */
    public function index()
    {

       $em = $this->getDoctrine()->getManager();
       $repositorio = $em->getRepository(Jugador::class);
       $equipo      = $em->getRepository(Equipo::class);
       $posicion    = $em->getRepository(Posicion::class);
       
       $jugadores = $repositorio->findAll();
       $view['jugadores'] = $jugadores;
       return $this->render('jugador/index.html.twig', $view);

    }
    
    /**
    * @Route("/jugador_new", name="jugador_new", methods={"GET"})
    */
    public function news()
    {
       $em = $this->getDoctrine()->getManager();
       $equipo   = $em->getRepository(Equipo::class);
       $posicion = $em->getRepository(Posicion::class);
       
       $equipos_all  = $equipo->findAll();
       $posicion_all = $posicion->findAll();
       
       $view['equipos']    = $equipos_all;
       $view['posiciones'] = $posicion_all;
       
        return $this->render('jugador/form.html.twig', $view);
    }
   
    /**
    * @Route("/jugador_save", name="jugador_save", methods={"POST"})
    */
    public function save(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $nombre      = $request->get('nombre');
        $equipo_id   = $request->get('equipo_id');
        $posicion_id = $request->get('posicion_id');
        $precio      = $request->get('precio');

        $jugador_new = new Jugador();
        $jugador_new->setNombre($nombre);
        $jugador_new->setEquipoId($equipo_id);
        $jugador_new->setPosicionId($posicion_id);
        $jugador_new->setPrecio($precio);
        
        $em->persist($jugador_new);
        $em->flush();
        
        return $this->redirectToRoute('jugador');
    }
    
    
    
    
    /**
    * @Route("/jugador_edit/{id}", name="jugador_edit", methods={"GET"})
    */
    public function edit($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Equipo::class);

        $equipo = $repositorio->find($id);
        $view['equipo'] = $equipo;
        return $this->render('jugador/edit.html.twig', $view);
    }
    
    /**
    * @Route("/jugador_update/{id}", name="jugador_update", methods={"POST"})
    */
    public function update($id, Request $request)
    {
        $nombre = $request->get('nombre');
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Equipo::class);

        $equipo = $repositorio->find($id);
        $equipo->setNombre($nombre);
        $em->persist($equipo);
        $em->flush();
        return $this->redirectToRoute('jugador');
    }
    
    
    
    
    
    
    /**
    * @Route("/jugador_delete/{id}", name="jugador_delete", methods={"GET"})
    */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Jugador::class);

        $equipo = $repositorio->find($id);
        $em->remove($equipo);
        $em->flush();
        return $this->redirectToRoute('jugador');
    }
    
    
}

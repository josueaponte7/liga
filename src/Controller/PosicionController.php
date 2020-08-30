<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Posicion;

class PosicionController extends AbstractController
{
    /**
     * @Route("/posicion", name="posicion")
     */
    public function index()
    {
        
       $em = $this->getDoctrine()->getManager();
       $repositorio = $em->getRepository(Posicion::class);
       $posiciones = $repositorio->findAll();
       $view['posiciones'] = $posiciones;
       return $this->render('posicion/index.html.twig', $view);
    }
    
    
    /**
    * @Route("/posicion_new", name="posicion_new", methods={"GET"})
    */
    public function news()
    {

        return $this->render('posicion/form.html.twig');
    }
   
    /**
    * @Route("/posicion_save", name="posicion_save", methods={"POST"})
    */
    public function save(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $nombre = $request->get('nombre');

        $posicion_new = new Posicion();
        $posicion_new->setNombre($nombre);
        $em->persist($posicion_new);
        $em->flush();
        return $this->redirectToRoute('posicion');
    }

    /**
    * @Route("/posicion_edit/{id}", name="posicion_edit", methods={"GET"})
    */
    public function edit($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Posicion::class);

        $posicion = $repositorio->find($id);
        $view['posicion'] = $posicion;
        return $this->render('posicion/edit.html.twig', $view);
    }
   
    /**
    * @Route("/posicion_update/{id}", name="posicion_update", methods={"POST"})
    */
    public function update($id, Request $request)
    {
        $nombre = $request->get('nombre');
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Posicion::class);

        $posicion = $repositorio->find($id);
        $posicion->setNombre($nombre);
        $em->persist($posicion);
        $em->flush();
        return $this->redirectToRoute('posicion');
    }
   
    /**
    * @Route("/posicion_delete/{id}", name="posicion_delete", methods={"GET"})
    */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Posicion::class);

        $posicion = $repositorio->find($id);
        $em->remove($posicion);
        $em->flush();
        return $this->redirectToRoute('posicion');
    }
   
   
   
}

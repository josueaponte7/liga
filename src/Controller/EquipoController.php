<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Equipo;

class EquipoController extends AbstractController
{
    /**
     * @Route("/equipo", name="equipo")
     */
    public function index()
    {
        
       $em = $this->getDoctrine()->getManager();
       $repositorio = $em->getRepository(Equipo::class);
       
       $equipos = $repositorio->findAll();
       $view['equipos'] = $equipos;
       return $this->render('equipo/index.html.twig', $view);
       
    }
    
    
    /**
    * @Route("/equipo_new", name="equipo_new", methods={"GET"})
    */
    public function news()
    {

        return $this->render('equipo/form.html.twig');
    }
   
    /**
    * @Route("/equipo_save", name="equipo_save", methods={"POST"})
    */
    public function save(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $nombre = $request->get('nombre');

        $equipo_new = new Equipo();
        $equipo_new->setNombre($nombre);
        $em->persist($equipo_new);
        $em->flush();
        return $this->redirectToRoute('equipo');
    }
    
    /**
    * @Route("/equipo_edit/{id}", name="equipo_edit", methods={"GET"})
    */
    public function edit($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Equipo::class);

        $equipo = $repositorio->find($id);
        $view['equipo'] = $equipo;
        return $this->render('equipo/edit.html.twig', $view);
    }
    
    /**
    * @Route("/equipo_update/{id}", name="equipo_update", methods={"POST"})
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
        return $this->redirectToRoute('equipo');
    }
    
     /**
    * @Route("/equipo_delete/{id}", name="equipo_delete", methods={"GET"})
    */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Equipo::class);

        $equipo = $repositorio->find($id);
        $em->remove($equipo);
        $em->flush();
        return $this->redirectToRoute('equipo');
    }
    
    
}

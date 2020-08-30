<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Posicion;
use App\Entity\Equipo;
use App\Entity\Jugador;
use App\Service\ExternoService;
/**
 * @Route("/api/v1")
 */
class ApiJugadorController extends AbstractController
{
    /**
     * @Route("/jugador/create", name="api_jugador_create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repositorio_posicion = $em->getRepository(Posicion::class);
        $repositorio_equipo   = $em->getRepository(Equipo::class);

        $nombre      = $request->get('nombre');
        $response_nombre     = ['codigo' => 404, 'msg' => 'Nombre no enviado'];
        if(!isset($nombre)){
            
            return $this->json($response_nombre);
            
        }
        
        $precio      = $request->get('precio');
        $response_precio     = ['codigo' => 404, 'msg' => 'Precio no enviado'];
        if(!isset($precio)){
            
            return $this->json($response_precio);
            
        }
        
        $equipoId    = $request->get('equipoId');
        $response_equipoId   = ['codigo' => 404, 'msg' => 'equipoId no enviado'];
        if(!isset($equipoId)){
            
            return $this->json($response_equipoId);
            
        }else{
            $equipo_ind    = $repositorio_equipo->find($equipoId);
            $response_equipo     = ['codigo' => 404, 'msg' => 'Equipo  no Encontrado'];
            if(!isset($equipo_ind)){

                return $this->json($response_equipo);

            } 
        }
        
        $posicionId  = $request->get('posicionId');
        $response_posicionId = ['codigo' => 404, 'msg' => 'posicionId no enviado'];
        if(!isset($posicionId)){
            
            return $this->json($response_posicionId);
            
        }else{
            
            $posicion_ind  = $repositorio_posicion->find($posicionId);
            $response_posicion   = ['codigo' => 404, 'msg' => 'Posicion  no Encontrada'];
            if(!isset($posicion_ind)){

                return $this->json($response_posicion);
            }
        }

                $jugador_api_new = new Jugador();
                $jugador_api_new->setNombre($nombre);
                $jugador_api_new->setEquipoId($equipoId);
                $jugador_api_new->setPosicionId($posicionId);
                $jugador_api_new->setPrecio($precio);

                $em->persist($jugador_api_new);
                $em->flush();

                
                $response = ['codigo' => 200, 'id' => $jugador_api_new->getId(), 'msg' => 'Jugador Registrado Corectamente'];
                
            return $this->json($response);
            
         
        
       
    }
    /**
     * @Route("/jugador/all", name="api_jugador_all", methods={"GET"})
     */
    public function list_posicion()
    {
       $em = $this->getDoctrine()->getManager();
       $repositorio = $em->getRepository(Jugador::class);
       $jugador = $repositorio->findAll();
       
       $response = ['codigo' => 404, 'msg' => 'No existen Jugadores Registrados'];
       if($jugador) {
            $response = ['codigo' => 200, 'listado' => $jugador];
       }
       return $this->json($response);
    }
    
    /**
     * @Route("/jugador/find/{id}/{money}", name="api_jugador_find", requirements={"id"="\d+"}, defaults={"money": "EUR"}, methods={"GET"})
     */
    public function find(int $id, string $money)
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
    
    /**
     * @Route("/jugador/edit/{id}", name="api_jugador_edit", methods={"PUT"})
     */
    public function edit($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Jugador::class);
        $repositorio_posicion = $em->getRepository(Posicion::class);
        $repositorio_equipo   = $em->getRepository(Equipo::class);

        $nombre      = $request->get('nombre');
        $precio      = $request->get('precio');
        
        $equipoId    = $request->get('equipoId');
        $posicionId  = $request->get('posicionId');
        

        $jugador_api_update = $repositorio->find($id);
        $response_jugador    = ['codigo' => 404, 'msg' => 'Jugador  no Encontrado'];
        if(isset($jugador_api_update)){
        
                if(isset($nombre)){
                     $jugador_api_update->setNombre($nombre);
                }

                if(isset($precio)){

                     $jugador_api_update->setPrecio($precio);
                }

                if(isset($equipoId)){

                    $equipo_ind    = $repositorio_equipo->find($equipoId);
                    $response_equipo     = ['codigo' => 404, 'msg' => 'Equipo  no Encontrado'];
                    if(!isset($equipo_ind)){

                        return $this->json($response_equipo);

                    }else{

                        $jugador_api_update->setEquipoId($equipoId);
                    }
                }

                if(isset($posicionId)){

                    $posicion_ind  = $repositorio_posicion->find($posicionId);
                    $response_posicion   = ['codigo' => 404, 'msg' => 'Posicion  no Encontrada'];
                    if(!isset($posicion_ind)){

                        return $this->json($response_posicion);
                    }else{

                        $jugador_api_update->setPosicionId($posicionId);
                    }

                }
                
                $em->persist($jugador_api_update);
                $em->flush();


                $response = ['codigo' => 200, 'id' => $jugador_api_update->getId(), 'msg' => 'Jugador Actualizado Corectamente'];

                    return $this->json($response); 
                }
                
            return $this->json($response_jugador);
        }
        
    
    /**
     * @Route("/jugador/delete/{id}", name="api_jugador_delete", methods={"DELETE"})
     */
    public function delete($id)
    {

        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Jugador::class);
        $jugador = $repositorio->find($id);

        $response = ['codigo' => 404, 'msg' => 'Jugador no Encontrado'];
        if($jugador) {

             $em->remove($jugador);
             $em->flush();

             $response = ['codigo' => 200, 'msg' => 'Jugador Eliminado Corectamente!!'];
        }
        return $this->json($response);
        
    }
    
    
    /**
     * @Route("/jugador/findListEquipo/{id}/{money}", name="api_jugador_findListEquipo", requirements={"id"="\d+"},  defaults={"money": "EUR"}, methods={"GET"})
     */
    public function find_list_equipo(int $id, string $money)
    {
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Equipo::class);
        $equipo = $repositorio->find($id);
  
        $response = ['codigo' => 404, 'msg' => 'Equipo no Encontrado'];
        if ($equipo) {
            
            $jugadores = $em->getRepository(Jugador::class);
            $listjugadores = $jugadores->findBy(['equipoId' => $id]);
            
            $response = ['codigo' => 404, 'msg' => 'No hay Jugadores en este Equipo'];
            
            if($listjugadores){
                $list = [];

                 foreach ($listjugadores as $value) {
                    $precio = $value->getPrecio();
                    $moneda = '€';
                    if($money !== 'EUR') {
                        $moneda = '$';
                        $service = new ExternoService();
                        $precio = $service->getMoney($precio);
                    }
                    $lista['id'] = $value->getId();
                    $lista['nombre'] = $value->getNombre();
                    $lista['precio'] = $precio. ' '.$moneda;
                    array_push($list, $lista);
                 }
                $response = ['codigo' => 200, 'jugadores' => $list];
                return $this->json($response);
            
            }else{
                return $this->json($response);
                
            }
            
        }
        
        return $this->json($response);
    }
    
    
    /**
     * @Route("/jugador/findListPosicion/{id}", name="api_jugador_findListPosicion", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function find_list_posicion($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Posicion::class);
        $posicion = $repositorio->find($id);
  
        $response = ['codigo' => 404, 'msg' => 'Posicion no Encontrada'];
        if ($posicion) {
            
            $jugadores = $em->getRepository(Jugador::class);
            $listjugadores = $jugadores->findBy(['posicionId' => $id]);
            
            $response = ['codigo' => 404, 'msg' => 'No hay Jugadores en esta Posicion'];
            
            if($listjugadores){
            
                $response = ['codigo' => 200, 'jugadores' => $listjugadores];
                return $this->json($response);
            
            }else{
                return $this->json($response);
                
            }
            
        }
         return $this->json($response);
        
        
    }
    
    
    /**
     * @Route("/jugador/findListEquiPosic/{id}/{ik}", name="api_jugador_findListEquiPosic", requirements={"id"="\d+","ik"="\d+"}, methods={"GET"})
     */
    public function find_list_equipo_posicion($id, $ik)
    {
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository(Equipo::class);
        $equipo      = $repositorio->find($id);
  
        $response = ['codigo' => 404, 'msg' => 'Equipo no Encontrado'];
        if ($equipo) {
            
                $response = ['codigo' => 404, 'msg' => 'Posicion no Encontrada'];
                $repo_posicion = $em->getRepository(Posicion::class);
                $posicion      = $repo_posicion->find($ik);
            
                if ($posicion) {
                    
                        $jugadores = $em->getRepository(Jugador::class);
                        $listjugadores = $jugadores->findBy(['equipoId' => $id,'posicionId' => $ik]);

                        $response = ['codigo' => 404, 'msg' => 'No hay Jugadores en Este Equipo para esta Posicion'];

                        if($listjugadores){

                            $response = ['codigo' => 200, 'jugadores' => $listjugadores];
                            return $this->json($response);

                        }else{
                            
                            return $this->json($response);

                        }
                }
                
            return $this->json($response);
        }
         return $this->json($response);
        
        
    }
    
    
    
}

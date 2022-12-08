<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\RendezVous;


class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api')]
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }
    /**
     * @Route("/api/{id}/{start}/edit", name="api_event_edit" ,methods={"PUT"})
     */
    public function majevent(?RendezVous $calendar,Request $request,$id,$start): Response
    {
       
        $rest = substr($start, 0, 28);
       
     
       
       
        $timestamp = strtotime($rest);

        // Subtract time from datetime
        $time = $timestamp - (4 * 60 * 60);
        
        // Date and time after subtraction
        $rest= date("Y-m-d H:i:s", $time); 
        $date= new \DateTime($rest);  
       
       if(isset($start)&& !empty($start)){
        
    
      
        $rep = $this->getDoctrine()->getRepository(RendezVous::class);
        $rendezVous= $rep->find($id) ;           
        $em= $this->getDoctrine()->getManager();
        $rendezVous->setDate($date);
      
          
            $newDate = new \Datetime($date->format('Y-m-d H:i:s'));
            $newDate=$newDate->add(new \DateInterval("PT30M"));
            $rendezVous->setDateEnd($newDate);
          
    
           
        
       
        $em->flush();
        return new Response('succees',200);}
        else{
            return new Response('echeck',404);
        }
    }
}

<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\MedecinSearch;
use App\Form\MedecinSearchType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;




#[Route('/listMed')]

class ListMedecinController extends AbstractController
{
    #[Route('/list/medecin', name: 'app_list_medecin')]
    public function index(): Response
    {
        return $this->render('list_medecin/index.html.twig', [
            'controller_name' => 'ListMedecinController',
        ]);
    }
    


    
    
    #[Route('/list', name: 'listMed', methods: ['GET'])]
    public function afficherList(EntityManagerInterface $entityManager,Request $request): Response
    {
        $search = new MedecinSearch();
        $form = $this->createForm(MedecinSearchType::class, $search);
        $form->handleRequest($request);


        $utilisateurs = $entityManager
            ->getRepository(Utilisateur::class)
            //->findByRole($search);
            ->findBy(['role' => 'MEDECIN']);
            //->findAll();
        if($form->isSubmitted() && $form->isValid()) {
   //on récupère le nom et specialite d'utilisateur tapé dans le formulaire
    $nom = $search->getNomMed();   
    $specialite = $search->getSpecialiteMed();   
    
    if ($specialite!="") {
        //si on a fourni une specialite d'utilisateur on affiche tous les profil ayant ce nom
$utilisateurs= $entityManager->getRepository(Utilisateur::class)->findBy(['specialite' => $specialite] );
}
elseif ($nom!="" ) {
    //si on a fourni un nom d'utilisateur on affiche tous les profil ayant ce nom
$utilisateurs= $entityManager->getRepository(Utilisateur::class)->findBy(['nom' => $nom] );
}

    else   
      //si si aucun nom/specialite n'est fourni on affiche tous les profils
      $utilisateurs= $entityManager->getRepository(Utilisateur::class)->findBy(['role' => 'MEDECIN']);
   }

        return $this->render('list_medecin/list.html.twig', [
            'utilisateurs' => $utilisateurs,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/detail/{idUser}', name: 'DetailMed', methods: ['GET'])]

    public function detailMed(Utilisateur $utilisateur): Response
    {
        return $this->render('list_medecin/detailMed.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    #[Route('/map', name: 'map', methods: ['GET'])]

    public function mapp(): Response
    {
        return $this->render('list_medecin/map.html.twig');
    }
    


}

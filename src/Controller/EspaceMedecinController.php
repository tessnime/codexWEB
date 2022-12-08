<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Entity\RendezVous;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\RendezVous1Type;
use App\Entity\CategorieRdv;
use App\Entity\RdvFiltre;



class EspaceMedecinController extends AbstractController
{
    #[Route('/espace/medecin', name: 'app_espace_medecin')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $events = $entityManager
            ->getRepository(RendezVous::class)
            ->findAll();
        $rdvs = [];
        foreach($events as $event){
            $rdvs[]=[
                'id' => $event->getIdRv(),
                'date' => $event->getDateRv()->format('Y-m-d'),
                'heure' => $event->getHeureRv(),
                'etat' => $event->getEtat(),
            ];
        }
        $data = json_encode($rdvs);
        
        return $this->render('espace_medecin/calendrier.html.twig', compact('data'));
    }

    #[Route('/espace/rdv', name: 'rdv', methods: ['GET'])]
    public function rdv(EntityManagerInterface $entityManager): Response
    {
        

        $rendezVouses = $entityManager
            ->getRepository(RendezVous::class)
            ->findAll();

        return $this->render('espace_medecin/listRdv.html.twig', [
            'rendez_vouses' => $rendezVouses,
        ]);
    }

    #[Route('/espace/{idUser}', name: 'profil', methods: ['GET'])]

    public function profil(Utilisateur $utilisateur): Response
    {
        return $this->render('espace_medecin/index.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    

    #[Route('/espace/rdv/{idRv}', name: 'show', methods: ['GET'])]
    public function show(RendezVous $rendezVou): Response
    {
        return $this->render('espace_medecin/show.html.twig', [
            'rendez_vou' => $rendezVou,
        ]);
    }

    #[Route('/espace/rdv/{idRv}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RendezVous $rendezVou, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RendezVous1Type::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('rdv', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('espace_medecin/edit.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form,
        ]);
    }
}

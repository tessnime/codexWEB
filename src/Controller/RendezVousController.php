<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Entity\CategorieRdv;
use App\Entity\Utilisateur;
use App\Form\RendezVousType;
use App\Form\CategorieRdvType;
use App\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/rendez/vous')]
class RendezVousController extends AbstractController
{
    #[Route('/', name: 'app_rendez_vous_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $rendezVouses = $entityManager
            ->getRepository(RendezVous::class)
            ->findAll();

        return $this->render('rendez_vous/index.html.twig', [
            'rendez_vouses' => $rendezVouses,
        ]);
    }

    #[Route('/new', name: 'app_rendez_vous_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,MailerService $mailer): Response
    {
        $rendezVou = new RendezVous();
        

          
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);
        
        if (($form->isSubmitted() && $form->isValid())) {
                $rendezVou->setEtat('En Attente');
                //$rendezVou->setIdPatient('6');
                //$rendezVou->setIdMedecin('7');
                $entityManager->persist($rendezVou);
                $entityManager->flush();

                $message = "Rendez vous est ajouter avec succés !";
                $mailMessage = 'Cher patient'.' '.$message;
                $this->addFlash('success',
                $message);
                $mailer->sendEmail(content: $mailMessage);

                //return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
                return $this->redirectToRoute('app_rendez_vous_newcat', [], Response::HTTP_SEE_OTHER); 
                //return $this->render('categorie_rdv/new.html.twig');   
                
        }
        
        return $this->renderForm('rendez_vous/new.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form,
            
        ]);
    }


    #[Route('/newcat', name: 'app_rendez_vous_newcat', methods: ['GET', 'POST'])]
    public function newcat(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorieRdv = new CategorieRdv();
        $formc = $this->createForm(CategorieRdvType::class, $categorieRdv);
        $formc->handleRequest($request);

        if ($formc->isSubmitted() && $formc->isValid()) {
            $entityManager->persist($categorieRdv);
            $entityManager->flush();

            return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie_rdv/new.html.twig', [
            'categorie_rdv' => $categorieRdv,
            'formc' => $formc,
        ]);
    }


    #[Route('/{idRv}', name: 'app_rendez_vous_show', methods: ['GET'])]
    public function show(RendezVous $rendezVou): Response
    {
        return $this->render('rendez_vous/show.html.twig', [
            'rendez_vou' => $rendezVou,
        ]);
    }

    #[Route('/{idRv}/edit', name: 'app_rendez_vous_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RendezVous $rendezVou, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rendez_vous/edit.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form,
        ]);
    }

    #[Route('/{idRv}', name: 'app_rendez_vous_delete', methods: ['POST'])]
    public function delete(Request $request, RendezVous $rendezVou, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rendezVou->getIdRv(), $request->request->get('_token'))) {
            $entityManager->remove($rendezVou);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
    }

    
}

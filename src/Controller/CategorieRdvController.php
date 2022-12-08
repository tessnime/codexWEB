<?php

namespace App\Controller;

use App\Entity\CategorieRdv;
use App\Form\CategorieRdvType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categorie/rdv')]
class CategorieRdvController extends AbstractController
{
    #[Route('/', name: 'app_categorie_rdv_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $categorieRdvs = $entityManager
            ->getRepository(CategorieRdv::class)
            ->findAll();

        return $this->render('categorie_rdv/index.html.twig', [
            'categorie_rdvs' => $categorieRdvs,
        ]);
    }

    #[Route('/new', name: 'app_categorie_rdv_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorieRdv = new CategorieRdv();
        $formc = $this->createForm(CategorieRdvType::class, $categorieRdv);
        $formc->handleRequest($request);

        if ($formc->isSubmitted() && $formc->isValid()) {
            $entityManager->persist($categorieRdv);
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_rdv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie_rdv/new.html.twig', [
            'categorie_rdv' => $categorieRdv,
            'form' => $formc,
        ]);
    }

    #[Route('/{idCategorieRdv}', name: 'app_categorie_rdv_show', methods: ['GET'])]
    public function show(CategorieRdv $categorieRdv): Response
    {
        return $this->render('categorie_rdv/show.html.twig', [
            'categorie_rdv' => $categorieRdv,
        ]);
    }

    #[Route('/{idCategorieRdv}/edit', name: 'app_categorie_rdv_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategorieRdv $categorieRdv, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieRdv1Type::class, $categorieRdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_rdv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie_rdv/edit.html.twig', [
            'categorie_rdv' => $categorieRdv,
            'form' => $form,
        ]);
    }

    #[Route('/{idCategorieRdv}', name: 'app_categorie_rdv_delete', methods: ['POST'])]
    public function delete(Request $request, CategorieRdv $categorieRdv, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieRdv->getIdCategorieRdv(), $request->request->get('_token'))) {
            $entityManager->remove($categorieRdv);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categorie_rdv_index', [], Response::HTTP_SEE_OTHER);
    }
}

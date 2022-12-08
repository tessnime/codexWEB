<?php

namespace App\Controller;

use App\Entity\Catégorie;
use App\Form\CatégorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cat/gorie')]
class CatégorieController extends AbstractController
{
    #[Route('/', name: 'app_cat_gorie_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $catégories = $entityManager
            ->getRepository(Catégorie::class)
            ->findAll();

        return $this->render('catégorie/index.html.twig', [
            'cat_gories' => $catégories,
        ]);
    }

    #[Route('/new', name: 'app_cat_gorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $catégorie = new Catégorie();
        $form = $this->createForm(CatégorieType::class, $catégorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($catégorie);
            $entityManager->flush();

            return $this->redirectToRoute('app_cat_gorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('catégorie/new.html.twig', [
            'cat_gorie' => $catégorie,
            'form' => $form,
        ]);
    }

    #[Route('/{idCategorie}', name: 'app_cat_gorie_show', methods: ['GET'])]
    public function show(Catégorie $catégorie): Response
    {
        return $this->render('catégorie/show.html.twig', [
            'cat_gorie' => $catégorie,
        ]);
    }

    #[Route('/{idCategorie}/edit', name: 'app_cat_gorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Catégorie $catégorie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CatégorieType::class, $catégorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_cat_gorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('catégorie/edit.html.twig', [
            'cat_gorie' => $catégorie,
            'form' => $form,
        ]);
    }

    #[Route('/{idCategorie}', name: 'app_cat_gorie_delete', methods: ['POST'])]
    public function delete(Request $request, Catégorie $catégorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$catégorie->getIdCategorie(), $request->request->get('_token'))) {
            $entityManager->remove($catégorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cat_gorie_index', [], Response::HTTP_SEE_OTHER);
    }
}

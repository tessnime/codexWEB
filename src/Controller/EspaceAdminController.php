<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\RendezVous;
use Doctrine\ORM\EntityManagerInterface;


class EspaceAdminController extends AbstractController
{
    #[Route('/espace/admin', name: 'app_espace_admin')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $rendezVouses = $entityManager
            ->getRepository(RendezVous::class)
            ->findAll();

        return $this->render('espace_admin/index.html.twig', [
            'rendez_vouses' => $rendezVouses,
        ]);
    }
}

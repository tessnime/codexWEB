<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\Utilisateur;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Illuminate\Support\Facades\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;




#[Route('/reclamation')]
class ReclamationController extends AbstractController
{
    #[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),

        ]);
    }

    #[Route('/admin', name: 'app_reclamation_index2', methods: ['GET'])]
    public function index2(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamation/indexAdmin.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),

        ]);
    }

    #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReclamationRepository $reclamationRepository, UtilisateurRepository $u): Response
    {
        $reclamation = new Reclamation();
        $id = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);

        $form->handleRequest($request);

        $session = new \Symfony\Component\HttpFoundation\Session\Session();
        $user = $u->find($session->getId());

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation->setIdUser($user);

            $reclamation->setMessage($this->filterwords($reclamation->getMessage()));
            $reclamationRepository->save($reclamation, true);


            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{idReclamation}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/{idReclamation}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{idReclamation}', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reclamation->getIdReclamation(), $request->request->get('_token'))) {
            $reclamationRepository->remove($reclamation, true);
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/pdf/mm', name: 'app_reclamation_pdf', methods: ['GET'])]
    public function pdfReclamation(ReclamationRepository $ReclamationRepository)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('reclamation/pdf.html.twig', [
            'reclamation' => $ReclamationRepository->findAll(),
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
        exit;
    }

    #[Route('/{idReclamation}/email', name: 'app_reclamation_email')]
    public function sendEmail(MailerInterface $mailer, Reclamation $reclamation, $idReclamation, ManagerRegistry $managerRegistry, ReclamationRepository $reclamationRepository): Response
    {


        $em = $managerRegistry->getManager();
        /*$session = new Session();
        $session->getId();
        $em->flush();*/
        $email = (new Email())
            ->from('tessnime.Kabbous@esprit.tn')
            ->to('achref.hjaiej@esprit.tn')
            ->subject('Medicanet')
            ->text('Sending emails is fun again!')
            ->html('<p>Bonjour ,

Nous avons bien reçu votre demande . Nous sommes sincèrement désolés pour ce désagrément. Nous mettons tout en œuvre pour résoudre ce problème au plus vite . Merci d’avance de votre patience.

En attendant. Vous y trouverez peut-être des réponses à votre question.

Cordialement,

Medicanet</p>');


        $mailer->send($email);
        $reclamation->setEtatReclamation('traité');
        $reclamationRepository->save($reclamation, true);


        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);

    }

    #[Route('/r/reclamation_stat', name: 'reclamation_stat', methods: ['GET'])]
    public function reclamation_stat(ReclamationRepository $reclamationRepository): Response
    {
        $nbrs[] = array();

        $e1 = $reclamationRepository->find_Nb_Rec_Par_Status("traite");
        dump($e1);
        $nbrs[] = $e1[0][1];
        $e2 = $reclamationRepository->find_Nb_Rec_Par_Status("non traite");
        dump($e2);
        $nbrs[] = $e2[0][1];

        dump($nbrs);
        reset($nbrs);
        dump(reset($nbrs));
        $key = key($nbrs);
        dump($key);
        dump($nbrs[$key]);

        unset($nbrs[$key]);

        $nbrss = array_values($nbrs);
        dump(json_encode($nbrss));

        return $this->render('reclamation/stat.html.twig', [
            'nbr' => json_encode($nbrss),
        ]);
    }


    function filterwords($text){
        $filterWords = array('shit','hello');
        $filterCount = sizeof($filterWords);
        for ($i = 0; $i < $filterCount; $i++) {
            $text = preg_replace_callback('/\b' . $filterWords[$i] . '\b/i', function($matches){return str_repeat('*', strlen($matches[0]));}, $text);
        }
        return $text;
    }
    #[Route('/r/search_rec', name: 'search_rec', methods: ['GET'])]
    public function search_rec(Request $request,NormalizerInterface $Normalizer,ReclamationRepository $reclamationRepository ): Response
    {

        $requestString=$request->get('searchValue');
        $requestString2=$request->get('searchValue2');
        $requestString3=$request->get('orderid');

        dump($requestString);
        dump($requestString2);
        $reclamations = $reclamationRepository->findReclamationsBySujet($requestString,$requestString2,$requestString3);
        dump($reclamations);
        $jsoncontentc =$Normalizer->normalize($reclamations,'json',['groups'=>'posts:read']);
        dump($jsoncontentc);
        $jsonc=json_encode($jsoncontentc);
        //   dump($jsonc);
        if(  $jsonc == "[]" )
        {
            return new Response(null);
        }
        else{        return new Response($jsonc);
        }

    }

    public function getData() :array
    {
        /**
         * @var $Reclamation rec[]
         */
        $list = [];
        // $reclam = $this->entityManager->getRepository(Reclamation::class)->findAll();
        $reclam = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();

        foreach ($reclam as $rec) {
            $list[] = [
                $rec->getIdReclamation(),
                $rec->getObjetReclamation(),
                $rec->getMessage(),
                $rec->getDateReclamation(),
                $rec->getEtatReclamation()

            ];
        }
        return $list;
    }







}


















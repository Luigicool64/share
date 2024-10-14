<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityRepository;
use App\Form\FichierType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Fichier;
use Symfony\Component\HttpFoundation\Request;

class FichierController extends AbstractController
{
    #[Route('/fichier', name: 'app_fichier')]
    public function fichier(Request $request, EntityManagerInterface $em): Response
    {
        $fichier = new Fichier();
        $form = $this->createForm(FichierType::class, $fichier);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $em->persist($fichier);
                $em->flush();
                $this->addFlash('notice','fichier envoyé');
                return $this->redirectToRoute('app_fichier');
            }
        }
        return $this->render('fichier/index.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}

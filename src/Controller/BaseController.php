<?php

namespace App\Controller;

use App\Controller\this;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BaseController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('base/index.html.twig', [

        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, EntityManagerInterface $em): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $contact->setDateEnvoi(new \Datetime());
                $em->persist($contact);
                $em->flush();
                $this->addFlash('notice', 'Message envoyé');
                return $this->redirectToRoute('app_contact');
            }
        }
        return $this->render('base/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/liste-user', name: 'app_user')]
    public function listeuser(UserRepository $UserRepository): Response
    {
        $Users = $UserRepository->findAll();
        return $this->render('base/liste-user.html.twig', [
            'users' => $Users,
        ]);
    }

    #[Route('/private-profil', name: 'app_profil')]
    public function profil(UserRepository $UserRepository): Response
    {
        $Users = $UserRepository->find($this ->getUser()->getId());
        return $this->render('base/profil.html.twig', [
            'users' => $Users,
        ]);
    }
};

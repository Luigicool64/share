<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/mod-liste-contacts', name: 'liste-contacts')]
    public function listeContacts(ContactRepository $contactRepository): Response
    {
        $contacts = $contactRepository->findAll();
        return $this->render('contact/liste-contacts.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    #[Route('/modifier-categorie', name: 'app_modifier_categorie')]
    public function modifierCategorie(): Response
    {
        return $this->render('categorie/modifier-categorie.html.twig', [
            
        ]);
    }
}

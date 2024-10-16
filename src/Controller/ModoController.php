<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\ModifierUserType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;


class ModoController extends AbstractController
{
    #[Route('/mod-liste_user', name: 'app_liste_user')]
    public function index(UserRepository $UserRepository): Response
    {
        $Users = $UserRepository->findAll();
        return $this->render('modo/liste_users.html.twig', [
            'Users' => $Users,
        ]);
    }

    #[Route('/mod-modifier-user/{id}', name: 'app_modifierUser')]
    public function modifierRole(Request $request, User $user, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ModifierUserType::class, $user);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($user);
                $em->flush();
                $this->addFlash('notice', 'user modifiée');
                return $this->redirectToRoute('app_liste_user');
            }
        }
        return $this->render('modo/modifier_user.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    #[Route('/mod-surprime-user/{id}', name: 'app_surprimeUser')]
    public function suprimeRole(Request $request, User $user, EntityManagerInterface $em): Response
    {
        if ($user != null) {
            $em->remove($user);
            $em->flush();
            $this->addFlash('notice', 'User supprimée');
        }
        return $this->redirectToRoute('app_liste_user');
    }

}

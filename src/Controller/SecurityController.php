<?php

namespace App\Controller;

use App\Form\RegisterType;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class SecurityController extends AbstractController
{
    private $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }


    #[Route('/register', name: 'security_register')]
    public function register(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        //analyse de la requete par le formulaire

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //traitement des donnees recues du formulaire
            //dd($user);
            $password_hash = $encoder->hashPassword($user, $user->getPassword());
            $user->setPassword($password_hash);
            $this->manager->persist($user);
            $this->manager->flush();
            return $this->redirectToRoute('security_login');
        }


        return $this->render('security/index.html.twig', [
            'controller_name' => "Formulaire d'inscription",
            'form' => $form->createView()
        ]);
    }


    #[Route('/login', name: 'security_login')]
    public function login(): Response
    {
        return $this->render('security/login.html.twig');
    }


    #[Route('/logout', name: 'security_logout')]
    public function logout()
    {
        //return $this->render('security/login.html.twig');
    }
}

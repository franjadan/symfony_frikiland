<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    #[Route('/registration', name: 'userRegistration')]
    public function userRegistration(Request $request, UserPasswordHasherInterface $passwordHaser): Response
    {
        $user = new User();
        $registrationForm = $this->createForm(UserType::class, $user);
        $registrationForm->handleRequest($request);

        if($registrationForm->isSubmitted() && $registrationForm->isValid()){
            $user->setPassword($passwordHaser->hashPassword($user, $registrationForm->get('password')->getData()));
            $user->setRoles(['ROLE_USER']);
            $this->em->persist($user);
            $this->em->flush();
            $this->redirectToRoute('userRegistration');
        };

        return $this->render('user/index.html.twig', [
            'registrationForm' => $registrationForm->createView()
        ]);
    }
}

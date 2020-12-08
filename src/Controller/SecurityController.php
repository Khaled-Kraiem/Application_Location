<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\SousCategoryRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(SousCategoryRepository $sousCategoryRepository): Response
    {
        return $this->render('security/index.html.twig', [
            'souscategories' => $sousCategoryRepository->findAll(),
        ]);
    }


    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder): Response
    {
        $activity = new Activity();
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $activity->setResponsable($user);
            $activity->setActionAt(new \DateTime());
            $activity->setAction('Un nouvel utilisateur s\'inscrire');
            $em->persist($user);
            $em->persist($activity);
            $em->flush($user);
            $em->flush($activity);
            return $this->redirectToRoute('security_login');
        }
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(Request $request, EntityManagerInterface $em)
    {
        $activity = new Activity();
        $user = $this->getUser();
        $activity->setResponsable($user);
        $activity->setActionAt(new \DateTime());
        $activity->setAction('Une nouvelle connexion');
        $em->persist($activity);
        $em->flush($activity);
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout()
    {
    }
}

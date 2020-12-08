<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\ActivityRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @@Route("/user",name="")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/user_profil", name="user_profil")
     */
    public function profile()
    {
        $user = $this->getUser();
        return $this->render('user/profil.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/edit_profil/{id}", name="edit_profil")
     */
    public function editProfil(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $activity = new Activity();
            $activity->setResponsable($this->getUser());
            $activity->setAction('Modifier Son profil');
            $activity->setActionAt(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($activity);
            $entityManager->flush();
            return $this->redirectToRoute('user_profil');
        }

        return $this->render('user/profil_edit.html.twig', [
            'category' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/list_utilisateur", name="list_utilisateur")
     */
    public function listUtilisateur(UserRepository $user): Response
    {
        $conectedUser = $this->getUser();
        $listUser = $user->getListeUser($conectedUser);
        return $this->render('user/list_user.html.twig', [
            'users' => $listUser,
        ]);
    }

    /**
     * @Route("/show_profil_utilisateur/{id}", name="show_profil_utilisateur")
     */
    public function showProfilUtilisateur(User $user): Response
    {
        return $this->render('user/profil_user_show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/activity", name="list_activity")
     */
    public function listActivity(ActivityRepository $activity): Response
    {
        $activitys = $activity->findAll();
        return $this->render('activity/index.html.twig', [
            'activitys' => $activitys,
        ]);
    }
}

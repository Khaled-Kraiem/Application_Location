<?php

namespace App\Controller;

use App\Entity\Caddy;
use App\Form\CaddyType;
use App\Repository\CaddyRepository;
use App\Repository\PublicationRepository;
use App\Repository\SousCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/caddy")
 */
class CaddyController extends AbstractController
{
    /**
     * @Route("/caddy", name="caddy_index", methods={"GET"})
     */
    public function index(PublicationRepository $publicationRepository, CaddyRepository $caddyRepository): Response
    {
        $user = $this->getUser();
        $mycaddy = $caddyRepository->getMyCaddy($user);
        $a = $caddyRepository->getNbrCaddy($user);
        // dump($a);
        // die;

        // dump($mycaddy);
        // die;

        return $this->render('caddy/index.html.twig', [
            'caddies' => $caddyRepository->getMyCaddy($user),
            // 'nbrcaddy' => $caddyRepository->getNbrCaddy($user)[0]
        ]);
    }

    /**
     * @Route("/admin_gestion_demandes", name="admin_gestion_demandes", methods={"GET"})
     */
    public function adminGestionDemandes(PublicationRepository $publicationRepository, CaddyRepository $caddyRepository): Response
    {
        return $this->render('caddy/admin_gestion_demandes.html.twig', [
            'caddies' => $caddyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/Nbr_caddy", name="caddy_nbr", methods={"GET"})
     */
    public function caddyNbr(PublicationRepository $publicationRepository, CaddyRepository $caddyRepository): Response
    {
        $user = $this->getUser();

        return $this->render('caddy/index.html.twig', [
            'caddyNbr' => $caddyRepository->getNbrCaddy($user),
        ]);
    }

    /**
     * @Route("/new", name="caddy_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $caddy = new Caddy();
        $form = $this->createForm(CaddyType::class, $caddy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($caddy);
            $entityManager->flush();

            return $this->redirectToRoute('caddy_index');
        }

        return $this->render('caddy/new.html.twig', [
            'caddy' => $caddy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="caddy_show", methods={"GET"})
     */
    public function show(Caddy $caddy): Response
    {
        return $this->render('caddy/show.html.twig', [
            'caddy' => $caddy,
        ]);
    }

    /**
     * @Route("/admin_demande_show/{id}", name="admin_demande_show", methods={"GET"})
     */
    public function adminDemandeShow(Caddy $caddy): Response
    {
        return $this->render('caddy/admin_caddy_show.html.twig', [
            'caddy' => $caddy,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="caddy_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Caddy $caddy): Response
    {
        $form = $this->createForm(CaddyType::class, $caddy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('caddy_index');
        }

        return $this->render('caddy/edit.html.twig', [
            'caddy' => $caddy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin_confirme/{id}", name="admin_confirme", methods={"GET","POST"})
     */
    public function adminConfirme(Request $request, Caddy $caddy): Response
    {
        // $caddy->getProduit()->getDisponibilite();
        // dump($caddy);
        // die;

        if ($caddy->getProduit()->getDisponibilite() == 1) {
            $caddy->getProduit()->setDisponibilite(0);
        } else {
            $caddy->getProduit()->setDisponibilite(1);
        }
        $this->getDoctrine()->getManager()->flush();

        return $this->render('caddy/admin_caddy_show.html.twig', [
            'caddy' => $caddy,
        ]);
    }

    /**
     * @Route("/{id}", name="caddy_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Caddy $caddy): Response
    {
        if ($this->isCsrfTokenValid('delete' . $caddy->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($caddy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('caddy_index');
    }
}

<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\SousCategory;
use App\Entity\Caddy;
use App\Entity\Publication;
use App\Form\PublicationType;
use App\Form\SousCategoryType;
use App\Repository\CaddyRepository;
use App\Repository\PublicationRepository;
use App\Repository\SousCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/publication")
 */
class PublicationController extends AbstractController
{

    private $repository;

    public function __construct(SousCategoryRepository $sousCategoryRepository)
    {
        $this->sousCategoryRepository = $sousCategoryRepository;
    }


    /**
     * @Route("/", name="publication_index", methods={"GET"})
     */
    public function index(PublicationRepository $publicationRepository): Response
    {
        $userConnected = $this->getUser();
        // dump($userConnected);die;
        return $this->render('publication/index.html.twig', [
            'publications' => $publicationRepository->getMyPublications($userConnected),
        ]);
    }

    /**
     * @Route("/admin_gestion_publications", name="admin_gestion_publications", methods={"GET"})
     */
    public function adminGestionPublications(PublicationRepository $publicationRepository): Response
    {
        return $this->render('publication/admin_publication.html.twig', [
            'publications' => $publicationRepository->findAll()
        ]);
    }

    /**
     * @Route("/offres_disponible", name="offres_disponible", methods={"GET"})
     */
    public function offresDisponible(PublicationRepository $publicationRepository): Response
    {
        $userConnected = $this->getUser();
        return $this->render('publication/offre_disponible.html.twig', [
            'publications' => $publicationRepository->getOffresDisponible($userConnected),
        ]);
    }


    /**
     * @Route("/new", name="publication_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $activity = new Activity();
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $activity->setResponsable($this->getUser());
            $activity->setAction('Ajouter Une annance');
            $activity->setActionAt(new \DateTime());
            $publication->setPublicateur($this->getUser());
            $publication->setVisible(0);
            $publication->setDisponibilite(0);
            $publication->setCreatedAt(new \DateTime());
            $entityManager->persist($activity);
            $entityManager->persist($publication);
            $entityManager->flush();

            return $this->redirectToRoute('publication_index');
        }

        return $this->render('publication/new.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="publication_show", methods={"GET"})
     */
    public function show(Publication $publication): Response
    {
        return $this->render('publication/show.html.twig', [
            'publication' => $publication,
        ]);
    }

    /**
     * @Route("/offre_show/{id}", name="offre_show", methods={"GET"})
     */
    public function offreShow(Publication $publication): Response
    {
        return $this->render('publication/offre_show.html.twig', [
            'publication' => $publication,
        ]);
    }

    /**
     * @Route("/admin_publication_show/{id}", name="admin_publication_show", methods={"GET"})
     */
    public function adminPublicationShow(Publication $publication): Response
    {
        return $this->render('publication/admin_publication_show.html.twig', [
            'publication' => $publication,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="publication_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Publication $publication): Response
    {
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publication_index');
        }

        return $this->render('publication/edit.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/admin_gestion_visibilite/{id}", name="admin_gestion_visibilite", methods={"GET","POST"})
     */
    public function adminGestionVisibilite(Request $request, Publication $publication): Response
    {

        if ($publication->getVisible() == 1) {
            $publication->setVisible(0);
        } else {
            $publication->setVisible(1);
        }

        // dump($publication);
        // die;
        $this->getDoctrine()->getManager()->flush();

        return $this->render('publication/admin_publication_show.html.twig', [
            'publication' => $publication,
        ]);
    }

    /**
     * @Route("/admin_gestion_disponibilite/{id}", name="admin_gestion_disponibilite", methods={"GET","POST"})
     */
    public function adminGestionDisponibilite(Request $request, Publication $publication): Response
    {

        if ($publication->getDisponibilite() == 1) {
            $publication->setDisponibilite(0);
        } else {
            $publication->setDisponibilite(1);
        }
        // dump($publication);
        // die;
        $this->getDoctrine()->getManager()->flush();

        return $this->render('publication/admin_publication_show.html.twig', [
            'publication' => $publication,
        ]);
    }

    /**
     * @Route("/{id}", name="publication_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Publication $publication): Response
    {
        if ($this->isCsrfTokenValid('delete' . $publication->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($publication);
            $entityManager->flush();
        }

        return $this->redirectToRoute('publication_index');
    }

    /**
     * @Route("/offre/add_Caddy/{id}", name="add_Caddy_offre", methods={"GET","POST"})
     */
    public function addCaddyOffre(CaddyRepository $caddyRepository, PublicationRepository $publicationRepository, SousCategoryRepository $sousCategoryRepository, Publication $publication): Response
    {
        // $sousCategory = $sousCategoryRepository->findOneBy(['id' => $publication]);
        $produit = $publication;
        $caddy = new Caddy();
        $entityManager = $this->getDoctrine()->getManager();
        $caddy->setLocateur($this->getUser());
        $caddy->setProduit($produit);
        $caddy->setCreatedAt(new \DateTime());
        // dump($caddy);
        // die;
        if ($caddyRepository->findOneBy([
            'locateur' => $this->getUser(),
            'produit' => $produit
        ])) {
            $message = "Vous avez déja a loué";
            // dump($message);
            // die;
            $this->addFlash('warning', 'Vous avez déjà soumis une demande de location pour ce produit,Merci de vérifier votre caddie !!!');
            return $this->redirectToRoute('offres_disponible');
        } else {
            $entityManager->persist($caddy);
            $entityManager->flush();
            $this->addFlash('success', 'Votre demande de location est en cours de traitement !!!');
            return $this->redirectToRoute('offres_disponible');
        }
    }
}

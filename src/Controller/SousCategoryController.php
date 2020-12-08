<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\SousCategory;
use App\Form\SousCategoryType;
use App\Repository\SousCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sous/category")
 */
class SousCategoryController extends AbstractController
{
    /**
     * @Route("/", name="sous_category_index", methods={"GET"})
     */
    public function index(SousCategoryRepository $sousCategoryRepository): Response
    {
        return $this->render('sous_category/index.html.twig', [
            'sous_categories' => $sousCategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sous_category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $activity = new Activity();

        $sousCategory = new SousCategory();
        $form = $this->createForm(SousCategoryType::class, $sousCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $activity->setResponsable($this->getUser());
            $activity->setAction('Ajouter Une Sous catégorie');
            $activity->setActionAt(new \DateTime());
            $entityManager->persist($sousCategory);
            $entityManager->persist($activity);
            $entityManager->flush();

            return $this->redirectToRoute('sous_category_index');
        }

        return $this->render('sous_category/new.html.twig', [
            'sous_category' => $sousCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sous_category_show", methods={"GET"})
     */
    public function show(SousCategory $sousCategory): Response
    {
        return $this->render('sous_category/show.html.twig', [
            'sous_category' => $sousCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sous_category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SousCategory $sousCategory): Response
    {
        $activity = new Activity();
        $form = $this->createForm(SousCategoryType::class, $sousCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activity->setResponsable($this->getUser());
            $activity->setAction('Modifier Une Sous catégorie');
            $activity->setActionAt(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($activity);
            $entityManager->flush();

            return $this->redirectToRoute('sous_category_index');
        }

        return $this->render('sous_category/edit.html.twig', [
            'sous_category' => $sousCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sous_category_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SousCategory $sousCategory): Response
    {
        if ($this->isCsrfTokenValid('delete' . $sousCategory->getId(), $request->request->get('_token'))) {
            $activity = new Activity();
            $activity->setResponsable($this->getUser());
            $activity->setAction('Supprimer Une Sous catégorie');
            $activity->setActionAt(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($activity);
            $entityManager->remove($sousCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sous_category_index');
    }
}

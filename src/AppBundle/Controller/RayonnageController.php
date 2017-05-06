<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Rayonnage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Rayonnage controller.
 *
 * @Route("rayonnage")
 */
class RayonnageController extends Controller
{
    /**
     * Lists all rayonnage entities.
     *
     * @Route("/", name="rayonnage_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Enregistrement
        $rayonnage = new Rayonnage();
        $form = $this->createForm('AppBundle\Form\RayonnageType', $rayonnage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em->persist($rayonnage);
            $em->flush();

            $this->addFlash('notice', "Le rayonnage ".$rayonnage->getNom()." a été crée avec succès.!");

            return $this->redirectToRoute('rayonnage_index');
        }

        // Liste des rayonnages
        $rayonnages = $em->getRepository('AppBundle:Rayonnage')->findAll();

        return $this->render('rayonnage/index.html.twig', array(
            'rayonnages' => $rayonnages,
            'rayonnage' => $rayonnage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new rayonnage entity.
     *
     * @Route("/new", name="rayonnage_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $rayonnage = new Rayonnage();
        $form = $this->createForm('AppBundle\Form\RayonnageType', $rayonnage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rayonnage);
            $em->flush();

            return $this->redirectToRoute('rayonnage_show', array('id' => $rayonnage->getId()));
        }

        return $this->render('rayonnage/new.html.twig', array(
            'rayonnage' => $rayonnage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a rayonnage entity.
     *
     * @Route("/{slug}", name="rayonnage_show")
     * @Method("GET")
     */
    public function showAction(Rayonnage $rayonnage)
    {
        $deleteForm = $this->createDeleteForm($rayonnage);

        return $this->render('rayonnage/show.html.twig', array(
            'rayonnage' => $rayonnage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing rayonnage entity.
     *
     * @Route("/{slug}/edit", name="rayonnage_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Rayonnage $rayonnage)
    {
        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($rayonnage);
        $editForm = $this->createForm('AppBundle\Form\RayonnageType', $rayonnage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('notice', "Le rayonnage ".$rayonnage->getNom()." a été modifié avec succès.!");

            return $this->redirectToRoute('rayonnage_index');
        }

        // Liste des rayonnages
        $rayonnages = $em->getRepository('AppBundle:Rayonnage')->findAll();

        return $this->render('rayonnage/edit.html.twig', array(
            'rayonnage' => $rayonnage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'rayonnages' => $rayonnages,
        ));
    }

    /**
     * Deletes a rayonnage entity.
     *
     * @Route("/{id}", name="rayonnage_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Rayonnage $rayonnage)
    {
        $form = $this->createDeleteForm($rayonnage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rayonnage);
            $em->flush();
        }

        return $this->redirectToRoute('rayonnage_index');
    }

    /**
     * Creates a form to delete a rayonnage entity.
     *
     * @param Rayonnage $rayonnage The rayonnage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rayonnage $rayonnage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rayonnage_delete', array('id' => $rayonnage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

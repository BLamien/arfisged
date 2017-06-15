<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Definitive;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Definitive controller.
 *
 * @Route("definitive")
 */
class DefinitiveController extends Controller
{
    /**
     * Lists all definitive entities.
     *
     * @Route("/", name="definitive_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Enregistrement
        $definitive = new Definitive();
        $form = $this->createForm('AppBundle\Form\DefinitiveType', $definitive);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($definitive);
            $em->flush();

            $this->addFlash('notice', "La côte definitive ".$definitive->getLibelle()." a été créée avec succès.!");

            return $this->redirectToRoute('definitive_index');
        }

        $definitives = $em->getRepository('AppBundle:Definitive')->findAll();

        return $this->render('definitive/index.html.twig', array(
            'definitives' => $definitives,
            'definitive' => $definitive,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new definitive entity.
     *
     * @Route("/new", name="definitive_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $definitive = new Definitive();
        $form = $this->createForm('AppBundle\Form\DefinitiveType', $definitive);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($definitive);
            $em->flush();

            return $this->redirectToRoute('definitive_show', array('id' => $definitive->getId()));
        }

        return $this->render('definitive/new.html.twig', array(
            'definitive' => $definitive,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a definitive entity.
     *
     * @Route("/{id}", name="definitive_show")
     * @Method("GET")
     */
    public function showAction(Definitive $definitive)
    {
        $deleteForm = $this->createDeleteForm($definitive);

        return $this->render('definitive/show.html.twig', array(
            'definitive' => $definitive,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing definitive entity.
     *
     * @Route("/{slug}/edit", name="definitive_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Definitive $definitive)
    {
        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($definitive);
        $editForm = $this->createForm('AppBundle\Form\DefinitiveType', $definitive);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('notice', "La côte définitive ".$definitive->getLibelle()." a été modifiée avec succès.!");

            return $this->redirectToRoute('definitive_index');
        }

        $definitives = $em->getRepository('AppBundle:Definitive')->findAll();

        return $this->render('definitive/edit.html.twig', array(
            'definitive' => $definitive,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'definitives' => $definitives,
        ));
    }

    /**
     * Deletes a definitive entity.
     *
     * @Route("/{id}", name="definitive_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Definitive $definitive)
    {
        $form = $this->createDeleteForm($definitive);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($definitive);
            $em->flush();

            $this->addFlash('notice', "La côte definitive ".$definitive->getLibelle()." a été supprimée avec succès.!");
        }

        return $this->redirectToRoute('definitive_index');
    }

    /**
     * Creates a form to delete a definitive entity.
     *
     * @param Definitive $definitive The definitive entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Definitive $definitive)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('definitive_delete', array('id' => $definitive->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

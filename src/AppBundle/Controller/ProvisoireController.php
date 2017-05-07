<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Provisoire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Provisoire controller.
 *
 * @Route("provisoire")
 */
class ProvisoireController extends Controller
{
    /**
     * Lists all provisoire entities.
     *
     * @Route("/", name="provisoire_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $provisoire = new Provisoire();
        $form = $this->createForm('AppBundle\Form\ProvisoireType', $provisoire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($provisoire);
            $em->flush();

            $this->addFlash('notice', "La côte provisoire ".$provisoire->getNom()." a été créée avec succès.!");

            return $this->redirectToRoute('provisoire_index');
        }

        $provisoires = $em->getRepository('AppBundle:Provisoire')->findAll();

        return $this->render('provisoire/index.html.twig', array(
            'provisoires' => $provisoires,
            'provisoire' => $provisoire,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new provisoire entity.
     *
     * @Route("/new", name="provisoire_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $provisoire = new Provisoire();
        $form = $this->createForm('AppBundle\Form\ProvisoireType', $provisoire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($provisoire);
            $em->flush();

            return $this->redirectToRoute('provisoire_show', array('id' => $provisoire->getId()));
        }

        return $this->render('provisoire/new.html.twig', array(
            'provisoire' => $provisoire,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a provisoire entity.
     *
     * @Route("/{id}", name="provisoire_show")
     * @Method("GET")
     */
    public function showAction(Provisoire $provisoire)
    {
        $deleteForm = $this->createDeleteForm($provisoire);

        return $this->render('provisoire/show.html.twig', array(
            'provisoire' => $provisoire,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing provisoire entity.
     *
     * @Route("/{slug}/edit", name="provisoire_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Provisoire $provisoire)
    {
        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($provisoire);
        $editForm = $this->createForm('AppBundle\Form\ProvisoireType', $provisoire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('notice', "La côte provisoire ".$provisoire->getNom()." a été modifiée avec succès.!");

            return $this->redirectToRoute('provisoire_index');
        }

        $provisoires = $em->getRepository('AppBundle:Provisoire')->findAll();

        return $this->render('provisoire/edit.html.twig', array(
            'provisoire' => $provisoire,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'provisoires' => $provisoires,
        ));
    }

    /**
     * Deletes a provisoire entity.
     *
     * @Route("/{id}", name="provisoire_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Provisoire $provisoire)
    {
        $form = $this->createDeleteForm($provisoire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($provisoire);
            $em->flush();

            $this->addFlash('notice', "La côte provisoire ".$provisoire->getNom()." a été supprimée avec succès.!");
        }

        return $this->redirectToRoute('provisoire_index');
    }

    /**
     * Creates a form to delete a provisoire entity.
     *
     * @param Provisoire $provisoire The provisoire entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Provisoire $provisoire)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('provisoire_delete', array('id' => $provisoire->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

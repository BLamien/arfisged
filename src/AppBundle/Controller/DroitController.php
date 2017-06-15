<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Droit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Droit controller.
 *
 * @Route("admin/droit")
 */
class DroitController extends Controller
{
    /**
     * Lists all droit entities.
     *
     * @Route("/", name="admin_droit_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Enregistrement
        $droit = new Droit();
        $form = $this->createForm('AppBundle\Form\DroitType', $droit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // Affection du niveau du gestionnaire
            $fonction = $droit->getFonction();
            switch ($fonction) {
              case 'STAGIAIRE':
                $niveau = 1;
                break;
              case 'ASSISTANT':
                $niveau = 2;
                break;
              case 'ADJOINT':
                $niveau = 3;
                break;
              case 'CHEF':
                $niveau = 4;
                break;
              case 'DIRECTEUR':
                $niveau = 5;
                break;

              default:
                $niveau = 0;
                break;
            }
            $droit->setNiveau($niveau);

            $em->persist($droit);
            $em->flush();

            return $this->redirectToRoute('admin_droit_index');
        }

        $droits = $em->getRepository('AppBundle:Droit')->findAll();

        return $this->render('droit/index.html.twig', array(
            'droits' => $droits,
            'droit' => $droit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new droit entity.
     *
     * @Route("/new", name="admin_droit_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $droit = new Droit();
        $form = $this->createForm('AppBundle\Form\DroitType', $droit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($droit);
            $em->flush();

            return $this->redirectToRoute('admin_droit_show', array('id' => $droit->getId()));
        }

        return $this->render('droit/new.html.twig', array(
            'droit' => $droit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a droit entity.
     *
     * @Route("/{id}", name="admin_droit_show")
     * @Method("GET")
     */
    public function showAction(Droit $droit)
    {
        $deleteForm = $this->createDeleteForm($droit);

        return $this->render('droit/show.html.twig', array(
            'droit' => $droit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing droit entity.
     *
     * @Route("/{id}/edit", name="admin_droit_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Droit $droit)
    {
        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($droit);
        $editForm = $this->createForm('AppBundle\Form\DroitType', $droit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_droit_edit', array('id' => $droit->getId()));
        }

        $droits = $em->getRepository('AppBundle:Droit')->findAll();

        return $this->render('droit/edit.html.twig', array(
            'droit' => $droit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'droits' => $droits,
        ));
    }

    /**
     * Deletes a droit entity.
     *
     * @Route("/{id}", name="admin_droit_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Droit $droit)
    {
        $form = $this->createDeleteForm($droit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($droit);
            $em->flush();
        }

        return $this->redirectToRoute('admin_droit_index');
    }

    /**
     * Creates a form to delete a droit entity.
     *
     * @param Droit $droit The droit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Droit $droit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_droit_delete', array('id' => $droit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

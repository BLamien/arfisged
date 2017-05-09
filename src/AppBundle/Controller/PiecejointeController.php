<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Piecejointe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Piecejointe controller.
 *
 * @Route("piecejointe")
 */
class PiecejointeController extends Controller
{
    /**
     * Lists all piecejointe entities.
     *
     * @Route("/", name="piecejointe_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $piecejointes = $em->getRepository('AppBundle:Piecejointe')->findAll();

        return $this->render('piecejointe/index.html.twig', array(
            'piecejointes' => $piecejointes,
        ));
    }

    /**
     * Creates a new piecejointe entity.
     *
     * @Route("/new", name="piecejointe_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $piecejointe = new Piecejointe();
        $form = $this->createForm('AppBundle\Form\PiecejointeType', $piecejointe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($piecejointe);
            $em->flush();

            return $this->redirectToRoute('piecejointe_show', array('id' => $piecejointe->getId()));
        }

        return $this->render('piecejointe/new.html.twig', array(
            'piecejointe' => $piecejointe,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a piecejointe entity.
     *
     * @Route("/{id}", name="piecejointe_show")
     * @Method("GET")
     */
    public function showAction(Piecejointe $piecejointe)
    {
        $deleteForm = $this->createDeleteForm($piecejointe);

        return $this->render('piecejointe/show.html.twig', array(
            'piecejointe' => $piecejointe,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing piecejointe entity.
     *
     * @Route("/{id}/edit", name="piecejointe_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Piecejointe $piecejointe)
    {
        $deleteForm = $this->createDeleteForm($piecejointe);
        $editForm = $this->createForm('AppBundle\Form\PiecejointeType', $piecejointe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('piecejointe_edit', array('id' => $piecejointe->getId()));
        }

        return $this->render('piecejointe/edit.html.twig', array(
            'piecejointe' => $piecejointe,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a piecejointe entity.
     *
     * @Route("/{id}", name="piecejointe_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Piecejointe $piecejointe)
    {
        $form = $this->createDeleteForm($piecejointe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($piecejointe);
            $em->flush();
        }

        return $this->redirectToRoute('piecejointe_index');
    }

    /**
     * Creates a form to delete a piecejointe entity.
     *
     * @param Piecejointe $piecejointe The piecejointe entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Piecejointe $piecejointe)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('piecejointe_delete', array('id' => $piecejointe->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

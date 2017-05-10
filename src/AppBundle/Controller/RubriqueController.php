<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Rubrique;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Rubrique controller.
 *
 * @Route("rubrique")
 */
class RubriqueController extends Controller
{
    /**
     * Lists all rubrique entities.
     *
     * @Route("/", name="rubrique_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        // test de droit d'accès
        $acces = $this->get('autorisation')->droitacces($user); // Service
        if ($acces) {
          return $acces;
        }

        // Enregistrement
        $rubrique = new Rubrique();
        $form = $this->createForm('AppBundle\Form\RubriqueType', $rubrique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rubrique);
            $em->flush();

            $this->addFlash('notice', "La rubrique ".$rubrique->getLibelle()." a été créée avec succès.!");

            return $this->redirectToRoute('rubrique_index');
        }

        $rubriques = $em->getRepository('AppBundle:Rubrique')->findAll();

        return $this->render('rubrique/index.html.twig', array(
            'rubriques' => $rubriques,
            'rubrique' => $rubrique,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new rubrique entity.
     *
     * @Route("/new", name="rubrique_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $rubrique = new Rubrique();
        $form = $this->createForm('AppBundle\Form\RubriqueType', $rubrique);
        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rubrique);
            $em->flush();

            return $this->redirectToRoute('rubrique_show', array('id' => $rubrique->getId()));
        }

        return $this->render('rubrique/new.html.twig', array(
            'rubrique' => $rubrique,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a rubrique entity.
     *
     * @Route("/{id}", name="rubrique_show")
     * @Method("GET")
     */
    public function showAction(Rubrique $rubrique)
    {
        $deleteForm = $this->createDeleteForm($rubrique);

        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        return $this->render('rubrique/show.html.twig', array(
            'rubrique' => $rubrique,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing rubrique entity.
     *
     * @Route("/{id}/edit", name="rubrique_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Rubrique $rubrique)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        // test de droit d'accès
        $acces = $this->get('autorisation')->droitacces($user); // Service
        if ($acces) {
          return $acces;
        }

        $deleteForm = $this->createDeleteForm($rubrique);
        $editForm = $this->createForm('AppBundle\Form\RubriqueType', $rubrique);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('notice', "La rubrique ".$rubrique->getLibelle()." a été modifiée avec succès.!");

            return $this->redirectToRoute('rubrique_index');
        }

        $rubriques = $em->getRepository('AppBundle:Rubrique')->findAll();

        return $this->render('rubrique/edit.html.twig', array(
            'rubrique' => $rubrique,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'rubriques' => $rubriques,
        ));
    }

    /**
     * Deletes a rubrique entity.
     *
     * @Route("/{id}", name="rubrique_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Rubrique $rubrique)
    {
        $form = $this->createDeleteForm($rubrique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rubrique);
            $em->flush();

            $this->addFlash('notice', "La rubrique ".$rubrique->getLibelle()." a été supprimée avec succès.!");
        }

        return $this->redirectToRoute('rubrique_index');
    }

    /**
     * Creates a form to delete a rubrique entity.
     *
     * @param Rubrique $rubrique The rubrique entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rubrique $rubrique)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rubrique_delete', array('id' => $rubrique->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

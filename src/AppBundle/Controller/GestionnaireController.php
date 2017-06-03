<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Gestionnaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Gestionnaire controller.
 *
 * @Route("admin/gestionnaire")
 */
class GestionnaireController extends Controller
{
    /**
     * Lists all gestionnaire entities.
     *
     * @Route("/", name="admin_gestionnaire_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Enregistrement
        $gestionnaire = new Gestionnaire();
        $form = $this->createForm('AppBundle\Form\GestionnaireType', $gestionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // Affection du niveau du gestionnaire
            $fonction = $gestionnaire->getFonction();
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
            $gestionnaire->setNiveau($niveau);

            $em->persist($gestionnaire);
            $em->flush();

            $this->addFlash('notice', "L'utilisateur ".$gestionnaire->getNom().' '.$gestionnaire->getPrenom()." a été crée avec succès.!");

            return $this->redirectToRoute('admin_gestionnaire_index');
        }

        $gestionnaires = $em->getRepository('AppBundle:Gestionnaire')->findAll();

        return $this->render('gestionnaire/index.html.twig', array(
            'gestionnaires' => $gestionnaires,
            'gestionnaire' => $gestionnaire,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new gestionnaire entity.
     *
     * @Route("/new", name="admin_gestionnaire_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $gestionnaire = new Gestionnaire();
        $form = $this->createForm('AppBundle\Form\GestionnaireType', $gestionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gestionnaire);
            $em->flush();

            return $this->redirectToRoute('admin_gestionnaire_show', array('slug' => $gestionnaire->getSlug()));
        }

        return $this->render('gestionnaire/new.html.twig', array(
            'gestionnaire' => $gestionnaire,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a gestionnaire entity.
     *
     * @Route("/{slug}", name="admin_gestionnaire_show")
     * @Method("GET")
     */
    public function showAction(Gestionnaire $gestionnaire)
    {
        $deleteForm = $this->createDeleteForm($gestionnaire);

        return $this->render('gestionnaire/show.html.twig', array(
            'gestionnaire' => $gestionnaire,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing gestionnaire entity.
     *
     * @Route("/{slug}/edit", name="admin_gestionnaire_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Gestionnaire $gestionnaire)
    {
        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($gestionnaire);
        $editForm = $this->createForm('AppBundle\Form\GestionnaireType', $gestionnaire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            // Affection du niveau du gestionnaire
            $fonction = $gestionnaire->getFonction();
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
            $gestionnaire->setNiveau($niveau);

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('notice', "L'utilisateur ".$gestionnaire->getNom().' '.$gestionnaire->getPrenom()." a été modifié avec succès.!");

            return $this->redirectToRoute('admin_gestionnaire_index');
        }

        $gestionnaires = $em->getRepository('AppBundle:Gestionnaire')->findAll();

        return $this->render('gestionnaire/edit.html.twig', array(
            'gestionnaire' => $gestionnaire,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'gestionnaires' => $gestionnaires,
        ));
    }

    /**
     * Deletes a gestionnaire entity.
     *
     * @Route("/{id}", name="admin_gestionnaire_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Gestionnaire $gestionnaire)
    {
        $form = $this->createDeleteForm($gestionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($gestionnaire);
            $em->flush();

            $this->addFlash('notice', "L'utilisateur ".$gestionnaire->getNom().' '.$gestionnaire->getPrenom()." a été supprimé avec succès.!");
        }

        return $this->redirectToRoute('admin_gestionnaire_index');
    }

    /**
     * Creates a form to delete a gestionnaire entity.
     *
     * @param Gestionnaire $gestionnaire The gestionnaire entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Gestionnaire $gestionnaire)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_gestionnaire_delete', array('id' => $gestionnaire->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

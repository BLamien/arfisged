<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Document;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Piecejointe;

/**
 * Document controller.
 *
 * @Route("document")
 */
class DocumentController extends Controller
{
    /**
     * Lists all document entities.
     *
     * @Route("/", name="document_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $documents = $em->getRepository('AppBundle:Document')->findAll();

        return $this->render('document/index.html.twig', array(
            'documents' => $documents,
        ));
    }

    /**
     * Creates a new document entity.
     *
     * @Route("/new", name="document_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $document = new Document();
        $form = $this->createForm('AppBundle\Form\DocumentType', $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($document);
            $em->flush();

            $this->addFlash('notice', "Le document ".$document->getReference()." a été sauvegardé avec succès.!");

            return $this->redirectToRoute('document_show', array('slug' => $document->getSlug()));
        }

        return $this->render('document/new.html.twig', array(
            'document' => $document,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a document entity.
     *
     * @Route("/{slug}", name="document_show")
     * @Method("GET")
     */
    public function showAction(Document $document)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($document);
        // recuperation de l'user
        $user = $this->getUser();

        $rubrique = $em->getRepository('AppBundle:Rubrique')->findOneById($document->getRubrique()->getId());
        $service = $em->getRepository('AppBundle:Service')->findOneById($rubrique->getService()->getId());
        $id = $document->getRubrique()->getId();

        // Si ROLE[0] est ROLE_USER alors recherche de la fonction dans gestionnaire.
        $roles[] = $user->getRoles();
        if ($roles[0][0] == 'ROLE_USER') {
          // Recherche du service de l'user depuis le gestionnaire.
          $gestionnaire = $em->getRepository('AppBundle:Gestionnaire')->findOneBy(array('user' => $user->getId()));

          // Si gestionnaire est null alors message vous n'êtes à aucun service.
          if ($gestionnaire == NULL) {
            // redigerer vers la page d'erreur
            $entete = "Oups!!!";
            $erreur = "100";
            $message = "Nous sommes désolés, vous n'êtes associé à aucun service. Veuillez contacter votre administrateur pour resourdre ce problème.";

            return $this->render('default/echec_acces.html.twig', array(
                'message' => $message,
                'entete'  => $entete,
                'erreur'  => $erreur,
            ));
          }

          $serviceGestionnaireID = $gestionnaire->getService()->getId();

          // on recupère le service de la rubrique en cours
          $rubrique = $em->getRepository('AppBundle:Rubrique')->findOneById($id);
          $serviceRubriqueID = $rubrique->getService()->getID();

          // si service user est different du service rubrique alors message pas de ce service
          if ($serviceRubriqueID != $serviceGestionnaireID) {
            // redigerer vers la page d'erreur
            $entete = "Accès réfusé";
            $erreur = "102";
            $message = "Nous sommes désolés, vous n'êtes pas de ce service. Veuillez contacter votre administrateur pour resourdre ce problème.";

            return $this->render('default/echec_acces.html.twig', array(
                'message' => $message,
                'entete'  => $entete,
                'erreur'  => $erreur,
            ));
          } else{
              $niveau = $gestionnaire->getNiveau();
              // Verifier l'existence d'une definition de droit d'accès
              // Sinon alors User peut visualiser la page
              $droit = $em->getRepository('AppBundle:Droit')->findOneBy(array('rubrique' => $id, 'niveau' => $niveau));

              // Si les droits n'ont pas été definis, alors message d'accès réfusé.
              if (!$droit) {
                $entete = "Oups!!!";
                $erreur = "105";
                $message = "Nous sommes désolés, vous ne pouvez pas accéder à cette rubrique. Veuillez contacter votre administrateur pour qu'il definisse vos droits d'accès.";

                return $this->render('default/echec_acces.html.twig', array(
                    'message' => $message,
                    'entete'  => $entete,
                    'erreur'  => $erreur,
                ));
              } else {
                $lecture = $droit->getLecture();
                $ecriture = $droit->getEcriture();
              }

          }
          // sinon verifier le droit dans droit d'acces
          // si pas ok alors message accès réfusé
        }

        $doc = $document->getPiecejointe();

        foreach ($doc as $key ) {
          $ext = $key->getUrl();
        }

        if (($ext == 'pdf') || ($ext == 'PDF')) {
          $fichier = 'icon-pdf.png';

          return $this->render('document/pdf.html.twig', array(
              'document' => $document,
              'delete_form' => $deleteForm->createView(),
              'fichier' => $fichier,
              'service' => $service,
              'rubrique' => $rubrique,
          ));

        } elseif (($ext == 'docx') || ($ext == 'DOCX') || ($ext == 'doc') || ($ext == 'DOC')) {
          $fichier = 'icon-word.png';

          return $this->render('document/word.html.twig', array(
              'document' => $document,
              'delete_form' => $deleteForm->createView(),
              'fichier' => $fichier,
              'service' => $service,
              'rubrique' => $rubrique,
          ));

        } elseif (($ext == 'xlsx') || ($ext == 'XLSX') || ($ext == 'xls') || ($ext == 'XLS')) {
          $fichier = 'icon-excel.png';

          return $this->render('document/excel.html.twig', array(
              'document' => $document,
              'delete_form' => $deleteForm->createView(),
              'fichier' => $fichier,
              'service' => $service,
              'rubrique' => $rubrique,
          ));

        } elseif(
            ($ext == 'jpg') || ($ext == 'JPG') || ($ext == 'jpeg') || ($ext == 'JPEG') ||
            ($ext == 'png') || ($ext == 'PNG') || ($ext == 'gif') || ($ext == 'GIF')
          ) {
          $fichier = 'icon-img.png';

          return $this->render('document/img.html.twig', array(
              'document' => $document,
              'delete_form' => $deleteForm->createView(),
              'fichier' => $fichier,
              'service' => $service,
              'rubrique' => $rubrique,
          ));

        } else{
          $fichier = 'icon-img.png';

          return $this->render('document/autre.html.twig', array(
              'document' => $document,
              'delete_form' => $deleteForm->createView(),
              'fichier' => $fichier,
              'service' => $service,
              'rubrique' => $rubrique,
          ));

        }

        return $this->render('document/show.html.twig', array(
            'document' => $document,
            'delete_form' => $deleteForm->createView(),
            'fichier' => $fichier,
            'service' => $service,
            'rubrique' => $rubrique,
        ));
    }

    /**
     * Displays a form to edit an existing document entity.
     *
     * @Route("/{slug}/edit", name="document_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Document $document)
    {
        $deleteForm = $this->createDeleteForm($document);
        $editForm = $this->createForm('AppBundle\Form\DocumentType', $document);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('notice', "Le document ".$document->getReference()." a été modifié avec succès.!");

            return $this->redirectToRoute('document_show', array('slug' => $document->getSlug()));
        }

        return $this->render('document/edit.html.twig', array(
            'document' => $document,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a document entity.
     *
     * @Route("/{id}", name="document_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Document $document)
    {
        $form = $this->createDeleteForm($document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($document);
            $em->flush();

            $this->addFlash('notice', "Le document ".$document->getReference()." a été supprimé avec succès.!");
        }

        return $this->redirectToRoute('document_index');
    }

    /**
     * Creates a form to delete a document entity.
     *
     * @param Document $document The document entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Document $document)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('document_delete', array('id' => $document->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a new document entity.
     *
     * @Route("/new/ajout-de-{rubrique}", name="document_new_user")
     * @Method({"GET", "POST"})
     */
    public function newUserAction(Request $request, $rubrique)
    {
        $document = new Document();
        $form = $this->createForm('AppBundle\Form\DocumentUserType', $document, array('rubrique' => $rubrique));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($document);
            $em->flush();

            $this->addFlash('notice', "Le document ".$document->getReference()." a été sauvegardé avec succès.!");

            return $this->redirectToRoute('document_show', array('slug' => $document->getSlug()));
        }

        return $this->render('document/new.html.twig', array(
            'document' => $document,
            'form' => $form->createView(),
        ));
    }
}

<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $userIp = $request->getClientIp();
        $user = $this->getUser();

        // Si la session user_connecte n'existe alors logger user vient de se connecter
        // sinon user consulte le tableau de bord
        if (!$session->has('userConnecte')) {
          $user = $this->getUser();
          $notification = $this->get('monolog.logger.notification');
          $notification->notice($user.' vient de se connecté sur la plateforme avec l\'ip: '.$userIp);

          $date = new \DateTime();
          //$datet = new \DateTimeZone('Europe/Paris');

          // Envoie de mail de notification à l'administrateur
          $message = \Swift_Message::newInstance()
                    ->setSubject('ARFISGED Notifications')
                    ->setFrom('noreply@arfis.com')
                    ->setTo('delrodieamoikon@gmail.com')
                    ->setBody(
                    $this->renderView('emails/connexion.html.twig', array(
                        'user' => $user,
                        'ip' => $userIp,
                        'date_connexion'  => $date->format('D d M Y h:i:s'),
                      )),
                        'text/html'
                    );
          $this->get('mailer')->send($message);

          // Enregistrement de la session
          $session->set('userConnecte', $this->getUser());

          // Si c'est une première connexion alors suggerer le changement de mot de passe.
          if (($user->getLoginCount()) === 1) return $this->render('default/pconnexion.html.twig');

        } else {
          $user = $this->getUser();
          $notification = $this->get('monolog.logger.notification');
          $notification->notice($user.' a consulté le tableau de bord .');
        }

        return $this->render('default/index.html.twig');
    }

    /**
     * Liste des services
     *
     * @Route("/rubriques", name="ged_rubriques")
     */
     public function rubriquesAction()
     {
       $em = $this->getDoctrine()->getManager();

       $rubriques = $em->getRepository('AppBundle:Service')->findOrderByNom();
       //dump($rubriques); die();

       return $this->render('default/rubrique.html.twig', [
           'rubriques'  => $rubriques,
       ]);
     }

    /**
     * Listes des rubriques (sous-rubriques)
     *
     * @Route("/{id}/sous-rubriques", name="ged_sous_rubriques")
     * @Method({"GET", "POST"})
     */
     public function sousrubriquesAction($id)
     {
       $em = $this->getDoctrine()->getManager();

       $sousrubriques = $em->getRepository('AppBundle:Rubrique')->findBy(
                                                                      array('service' => $id),
                                                                      array('libelle' => 'ASC')
                                                                    );
       //dump($sousrubriques); die();

       return $this->render('default/sousrubrique.html.twig', [
           'sousrubriques'  => $sousrubriques,
       ]);
     }

    /**
     * Statistique du nombre du type de document
     *
     * @Route("/statistiques-nombre-type-document-{type}", name="statistique_nombre_type_document")
     * @Method({"GET", "POST"})
     */
    public function typeDocumentAction($type)
    {
          $em = $this->getDoctrine()->getManager();
          $nombre = $em->getRepository('AppBundle:Piecejointe')->countTypeDocument($type);
          return $this->render('default/nombre.html.twig', array('nombre' => $nombre));
    }

    /**
     * Liste des services
     *
     * @Route("/accueil/services", name="accueil_services")
     */
    public function listeServiceAction()
    {
        $em = $this->getDoctrine()->getManager();
        $services = $em->getRepository('AppBundle:Service')->findOrderByNom();
        return $this->render('default/accueil_services.html.twig', array('services' => $services));
    }

    /**
     * Liste des rubrique selon le service
     *
     * @Route("/accueil/rubriques{service}", name="accueil_rubriques")
     */
    public function listeRubriqueAction($service)
    {
        $em = $this->getDoctrine()->getManager();
        $rubriques = $em->getRepository('AppBundle:Rubrique')->findBy(
                                                                       array('service' => $service),
                                                                       array('libelle' => 'ASC')
                                                                     );
        return $this->render('default/accueil_rubriques.html.twig', array('rubriques' => $rubriques));
    }

    /**
     * Nombre de document par rubriques
     *
     * @Route("/statistiques/nombre-document{rubrique}", name="statistique_nombre_document_rubrique")
     */
    public function nbServiceDocument($rubrique)
    {
        $em = $this->getDoctrine()->getManager();
        $nombre = $em->getRepository('AppBundle:Document')->countDocumentByRubrique($rubrique);
        return $this->render('default/nombre.html.twig', array('nombre' => $nombre));
    }
}

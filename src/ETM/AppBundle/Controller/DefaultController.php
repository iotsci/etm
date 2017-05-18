<?php

namespace ETM\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    public function indexAction()
    {

        return $this->render('AppBundle:Default:index.html.twig');
    }

    /**
     * @Route("ping")
     */
    public function pingAction()
    {
        $communicator = $this->get('etm_system_communicator');
        return new JsonResponse($communicator->ping());
    }
}

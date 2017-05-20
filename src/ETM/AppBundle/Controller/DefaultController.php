<?php

namespace ETM\AppBundle\Controller;

use ETM\AppBundle\Types\PassengerQuantityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('AppBundle::index.html.twig');
    }

    /**
     * @Route("ping")
     * @Method("GET")
     */
    public function pingAction()
    {
        $communicator = $this->get('etm_system_communicator');
        return new JsonResponse($communicator->ping());
    }

    /**
     * @Route("iata.json")
     * @Method("GET")
     */
    public function getIATAAction()
    {
        return new JsonResponse(json_decode($this->get('iata_fetcher')->fetch()));
    }

    /**
     * @Route("passenger_types.json")
     * @Method("GET")
     */
    public function getPassengerTypesAction()
    {
        return new JsonResponse([
            PassengerQuantityType::ADT => 'Adult',
            PassengerQuantityType::CHD => 'Child',
            PassengerQuantityType::INF => 'Infant'
        ]);
    }

    /**
     * @Route("add_search_request")
     * @Method("POST")
     */
    public function addSearchRequestAction(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');
        $departureDate = \DateTime::createFromFormat('d/m/Y', $request->get('departure_date'));
        $passengerType = $request->get('passenger_type');
        $passengerQuantity = (int) $request->get('passenger_quantity');

        return new JsonResponse([$from, $to, $departureDate, $passengerType, $passengerQuantity]);
    }
}

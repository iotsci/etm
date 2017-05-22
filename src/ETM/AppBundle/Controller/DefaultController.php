<?php

namespace ETM\AppBundle\Controller;

use ETM\AppBundle\Types\PassengerQuantityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        return new JsonResponse(PassengerQuantityType::getTypes());
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

        $communicator = $this->get('etm_system_communicator');

        return new JsonResponse($communicator->doAirFareRequest($from, $to, $departureDate, $passengerType, $passengerQuantity));
    }

    /**
     * @Route("get_request_result/{requestId}")
     * @Method("GET")
     * @param integer $requestId
     * @return JsonResponse
     */
    public function getRequestResultAction($requestId)
    {
        $communicator = $this->get('etm_system_communicator');

        return new JsonResponse($communicator->getAirFareResult($requestId));
    }

    /**
     * @Route("output_result/{request_id}")
     * @Method("GET")
     * @param integer $request_id
     * @return Response
     */
    public function outputResultsAction($request_id)
    {
        $communicator = $this->get('etm_system_communicator');

        $result = $communicator->getAirFareResult($request_id);
        return $this->render('AppBundle::result.html.twig', ["results" => $result->FareDisplayInfos]);
    }
}

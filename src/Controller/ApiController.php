<?php


namespace App\Controller;


use App\Services\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 * @package App\Controller
 */
class ApiController extends Controller
{

    private $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function tempVariationAction(Request $request)
    {
        $mode = $request->query->get('mode');
        $this->apiService->sendEmail($mode);

        $activate = $this->getParameter('activate_vent');

        if($activate){
            if( ! is_null($mode) && $mode === 'high'){
                $resp = $this->apiService->activateVent();
                $ledResp = $this->apiService->turnLedOn();
            }
            else{
                $resp = $this->apiService->deactivateVent();
                $ledResp = $this->apiService->turnLedOff();
            }

        }

        return new JsonResponse([
            'email_sent' => true,
            'activation_vent_response' => $resp,
            'led_response' => $ledResp
        ]);
    }
}
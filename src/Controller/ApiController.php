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
        $temp = $request->query->get('temperature');
        $mode = $request->query->get('mode');
        $this->apiService->sendEmail($temp, $mode);

        $activate = $this->getParameter('activate_vent');

        if($activate){
            if( ! is_null($mode) && $mode === 'high'){
                $resp = $this->apiService->activateVent();
            }
            else{
                $resp = $this->apiService->deactivateVent();
            }

        }

        return new JsonResponse([
            'email_sent' => true,
            'activation_vent_response' => $resp
        ]);
    }
}
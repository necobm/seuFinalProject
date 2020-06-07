<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @package App\Controller
 */
class DashboardController extends Controller
{
    /**
     * @Route(name="dashboard_index", path="/")
     */
    public function indexAction()
    {
        return $this->render('index.html.twig');
    }
}
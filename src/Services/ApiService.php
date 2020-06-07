<?php


namespace App\Services;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiService
{
    private $container;
    private $unirest;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->unirest = new \Unirest\Request();
    }

    public function sendEmail($temp, $mode)
    {
        $email = $this->container->getParameter('email_alerts');
        $message = (new \Swift_Message())
            ->setFrom($this->container->getParameter('email_from'))
            ->setTo($email)
            ->setBody(

                $this->container->get('twig')->render(
                    'Email/email_temperatura.html.twig',
                    ['temp' => $temp,'mode' => $mode]
                ),
                'text/html'
            );

        $this->container->get('mailer')->send($message);
    }

    public function activateVent()
    {
        $talkBackAccess = $this->getTalkBackAccess();

        $resp = $this->unirest->post(
            "https://api.thingspeak.com/talkbacks/".$talkBackAccess['id']."/commands?api_key=".$talkBackAccess['apiKey']."&command_string=TURN_LEFT"
        );

        return $resp;

    }

    public function deactivateVent()
    {
        $talkBackAccess = $this->getTalkBackAccess();

        $resp = $this->unirest->post(
            "https://api.thingspeak.com/talkbacks/".$talkBackAccess['id']."/commands?api_key=".$talkBackAccess['apiKey']."&command_string=TURN_RIGHT"
        );

        return $resp;
    }

    private function getTalkBackAccess()
    {
        $apiKey = $this->container->getParameter('talkback_api_key');
        $talkBackId = $this->container->getParameter('talkback_id');

        return [
            'apiKey' => $apiKey,
            'id' => $talkBackId
        ];
    }

}
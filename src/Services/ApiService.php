<?php


namespace App\Services;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiService
{
    private $container;
    private $unirest;

    const COMMAND_SERVO_ON = 'TURN_SERVO_ON';
    const COMMAND_SERVO_OFF = 'TURN_SERVO_OFF';
    const COMMAND_LED_ON = 'TURN_ON';
    const COMMAND_LED_OFF = 'TURN_OFF';

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->unirest = new \Unirest\Request();
    }

    public function sendEmail($mode)
    {
        $email = $this->container->getParameter('email_alerts');
        $message = (new \Swift_Message())
            ->setFrom($this->container->getParameter('email_from'))
            ->setTo($email)
            ->setBody(

                $this->container->get('twig')->render(
                    'Email/email_temperatura.html.twig',
                    ['mode' => $mode]
                ),
                'text/html'
            );

        $this->container->get('mailer')->send($message);
    }

    public function activateVent()
    {
        return $this->sendRequestToTalkBack(self::COMMAND_SERVO_ON);
    }

    public function deactivateVent()
    {
        return $this->sendRequestToTalkBack(self::COMMAND_SERVO_OFF);
    }

    public function turnLedOn()
    {
        return $this->sendRequestToTalkBack(self::COMMAND_LED_ON);
    }

    public function turnLedOff()
    {
        return $this->sendRequestToTalkBack(self::COMMAND_LED_OFF);
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

    private function sendRequestToTalkBack($command)
    {
        $talkBackAccess = $this->getTalkBackAccess();
        $resp = $this->unirest->post(
            "https://api.thingspeak.com/talkbacks/".$talkBackAccess['id']."/commands?api_key=".$talkBackAccess['apiKey']."&command_string=".$command
        );
        return $resp;
    }

}
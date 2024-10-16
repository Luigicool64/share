<?php
namespace App\EventListener;


use Symfony\Component\Security\Http\Event\AuthenticationFailureEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class LoginThrottleListener
{
    private $maxAttempts;

    private $delay;


    public function __construct($maxAttempts, $delay)

    {
        $this->maxAttempts = $maxAttempts;
        $this->delay = $delay;
    }


    public function onAuthenticationFailure(AuthenticationFailureEvent $event)

    {

        $request = $event->getRequest();

        $ipAddress = $request->getClientIp();


        // Increment the attempt count

        $attemptCount = $this->getAttemptCount($ipAddress);

        $attemptCount++;


        // Store the attempt count

        $this->storeAttemptCount($ipAddress, $attemptCount);


        // Check if the maximum attempts have been reached

        if ($attemptCount >= $this->maxAttempts) {

            // Block the access for a certain delay

            $response = new Response('Trop de tentatives. Veuillez réessayer plus tard.', 429);

            $event->setResponse($response);

        }

    }


    private function getAttemptCount($ipAddress)

    {

        // Implement a method to retrieve the attempt count from a storage (e.g. database, cache)

        // For example:

        return apc_fetch("login_attempts_$ipAddress") ?: 0;

    }


    private function storeAttemptCount($ipAddress, $attemptCount)

    {

        // Implement a method to store the attempt count in a storage (e.g. database, cache)

        // For example:

        apc_store("login_attempts_$ipAddress", $attemptCount, $this->delay);

    }

}

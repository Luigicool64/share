<?php
namespace App\Event;


use Symfony\Component\EventDispatcher\Event;


class UserActivityEvent extends Event

{

    const NAME = 'user.activity';


    private $id;

    private $action;


    public function __construct($id, $action)

    {

        $this->id = $id;

        $this->action = $action;

    }


    public function getId()

    {

        return $this->id;

    }


    public function getAction()

    {

        return $this->action;

    }
}
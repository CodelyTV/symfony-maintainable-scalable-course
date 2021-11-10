<?php

namespace AppBundle\Model;

class Event
{
    private $name;
    private $date;

    public function __construct($name, \DateTime $date)
    {
        $this->name = $name;
        $this->date = $date;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }
}

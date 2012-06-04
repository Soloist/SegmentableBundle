<?php

namespace Soloist\Bundle\SegmentableBundle\Entity;

class Segment
{
    protected $id;

    /**
     * @var string
     */
    protected $hostname;

    /**
     * @param string $hostname
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;
    }

    /**
     * @return string
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    public function getId()
    {
        return $this->id;
    }
}

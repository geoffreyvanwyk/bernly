<?php

namespace Bernly\Domain\Link;

class DomainName
{
    /**
     * @var string
     */
    private $value;

    public function __construct($domainName)
    {
        $this->value = $domainName;
    }

    public function equals(DomainName $that)
    {
        return strtolower($this->value()) === strtolower($that->value());
    }

    public function value()
    {
        return $this->value;
    }
}

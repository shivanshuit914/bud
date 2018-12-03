<?php

namespace Domain;

class Prisoner
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var array
     */
    private $address;

    private function __construct(string $name, array $address)
    {
        $this->name = $name;
        $this->address = $address;
    }

    public static function withNameAndAddress(string $name, array $address): Prisoner
    {
        return new static($name, $address);
    }

    public function getAddress(): array
    {
        return $this->address;
    }
}

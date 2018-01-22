<?php

namespace user\ex2\SocketServer;
use InvalidArgumentException;
use otus\user\ugraweb\ex1\ValidatorSequence;

class Validator {
    private $sequence;

    public function __construct($sequence)
    {
        $this->sequence = $sequence;
    }


    public function checkSequence()
    {
        try {
            $object = new ValidatorSequence($this->sequence);
        } catch (InvalidArgumentException $exception) {
            return "sequence is not valid";
        }
        if ($object->checkSequence()) {
            return "sequence is correct";
        } else return "sequence is not correct";
    }
}
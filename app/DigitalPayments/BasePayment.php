<?php

namespace App\DigitalPayments;

abstract class BasePayment
{
    abstract public function receive();
}
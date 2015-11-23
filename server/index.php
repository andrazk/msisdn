<?php

require __DIR__ . '/src/autoload.php';

$carrierMapper = libphonenumber\PhoneNumberToCarrierMapper::getInstance();
$numberUtil = libphonenumber\PhoneNumberUtil::getInstance();

$serverInstance = new Msidn\Server\Instance($numberUtil, $carrierMapper);

$server = new JsonRpc\Server($serverInstance);
$server->receive();

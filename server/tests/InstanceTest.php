<?php

use Msidn\Server\Instance;
use libphonenumber\PhoneNumberUtil;

class InstanceTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test if construct set number util
     * @return void
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function test_construct()
    {
        $numberUtil = PhoneNumberUtil::getInstance();
        $instance = new Instance($numberUtil);

        $this->assertInstanceOf('libphonenumber\PhoneNumberUtil', $instance->getNumberUtil());
    }
}

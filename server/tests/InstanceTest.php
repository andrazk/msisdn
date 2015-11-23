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

    /**
     * test if parse call numberutli parse
     * @return void
     * @author Andraz <andraz@easistent.com>
     */
    public function test_parse()
    {
        $msisdn = '+38640658494';

        $numberUtilMock = Mockery::mock('libphonenumber\PhoneNumberUtil');
        $numberUtilMock->shouldReceive('parse')->with($msisdn, null)->once();

        $instance = new Instance($numberUtilMock);

        $actual = $instance->parse($msisdn);

        $this->assertInstanceOf('Msidn\Server\Instance', $actual);
    }
}

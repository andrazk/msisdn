<?php

use Msidn\Server\Instance;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberToCarrierMapper;

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
        $carrierMapper = PhoneNumberToCarrierMapper::getInstance();

        $instance = new Instance($numberUtil, $carrierMapper);

        $this->assertInstanceOf('libphonenumber\PhoneNumberUtil', $instance->getNumberUtil());
        $this->assertInstanceOf('libphonenumber\PhoneNumberToCarrierMapper', $instance->getCarrierMapper());
    }

    /**
     * test if parse calls numberUtil parse
     * @return void
     * @author Andraz <andraz@easistent.com>
     */
    public function test_parse()
    {
        $msisdn = '+38640658494';

        $phoneNumberMock = Mockery::mock('libphonenumber\PhoneNumber');
        $phoneNumberMock->shouldReceive('getCountryCode')->once()->andReturn('386');
        $phoneNumberMock->shouldReceive('getNationalNumber')->once()->andReturn('40658494');

        $numberUtilMock = Mockery::mock('libphonenumber\PhoneNumberUtil');
        $numberUtilMock->shouldReceive('isValidNumber')->with($phoneNumberMock)->once()->andReturn(true);
        $numberUtilMock->shouldReceive('parse')->with($msisdn, null)->once()->andReturn($phoneNumberMock);
        $numberUtilMock->shouldReceive('getRegionCodeForNumber')->with($phoneNumberMock)->once()->andReturn('SI');

        $carrierMapperMock = Mockery::mock('libphonenumber\PhoneNumberToCarrierMapper');
        $carrierMapperMock->shouldReceive('getNameForNumber')->with($phoneNumberMock, 'en_US')->once()->andReturn('Si.mobil');

        $instance = new Instance($numberUtilMock, $carrierMapperMock);

        $actual = $instance->parse($msisdn);

        $this->assertInstanceOf('Msidn\Server\Instance', $actual);
        $this->assertTrue($actual->valid);
        $this->assertSame(386, $actual->countryDiallingCode);
        $this->assertSame('SI', $actual->countryIdentifier);
        $this->assertSame('Si.mobil', $actual->mnoIdentifier);
        $this->assertSame('40658494', $actual->subscriberNumber);
    }
}

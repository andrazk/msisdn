<?php

use Msidn\Server\Instance;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberToCarrierMapper;
use libphonenumber\NumberParseException;

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

    /**
     * Test if exception on parse is caught
     * @return void
     * @author Andraz <andraz@easistent.com>
     */
    public function test_parse_exception()
    {
        $msisdn = '+35345';

        $exception = new NumberParseException(NumberParseException::NOT_A_NUMBER, "The phone number supplied was null.");

        $phoneNumberMock = Mockery::mock('libphonenumber\PhoneNumber');

        $numberUtilMock = Mockery::mock('libphonenumber\PhoneNumberUtil');
        $numberUtilMock->shouldReceive('parse')->with($msisdn, null)->once()->andThrow($exception);

        $carrierMapperMock = Mockery::mock('libphonenumber\PhoneNumberToCarrierMapper');

        $instance = new Instance($numberUtilMock, $carrierMapperMock);

        $actual = $instance->parse($msisdn);

        $this->assertInstanceOf('Msidn\Server\Instance', $actual);
        $this->assertFalse($actual->valid);
        $this->assertSame(0, $actual->countryDiallingCode);
        $this->assertSame('', $actual->countryIdentifier);
        $this->assertSame('', $actual->mnoIdentifier);
        $this->assertSame('', $actual->subscriberNumber);
    }

    /**
     * Test if returns on invalid number
     * @return void
     * @author Andraz <andraz@easistent.com>
     */
    public function test_parse_invalid_number()
    {
        $msisdn = '+35345';

        $exception = new NumberParseException(NumberParseException::NOT_A_NUMBER, "The phone number supplied was null.");

        $phoneNumberMock = Mockery::mock('libphonenumber\PhoneNumber');

        $numberUtilMock = Mockery::mock('libphonenumber\PhoneNumberUtil');
        $numberUtilMock->shouldReceive('isValidNumber')->with($phoneNumberMock)->once()->andReturn(false);
        $numberUtilMock->shouldReceive('parse')->with($msisdn, null)->once()->andReturn($phoneNumberMock);

        $carrierMapperMock = Mockery::mock('libphonenumber\PhoneNumberToCarrierMapper');

        $instance = new Instance($numberUtilMock, $carrierMapperMock);

        $actual = $instance->parse($msisdn);

        $this->assertInstanceOf('Msidn\Server\Instance', $actual);
        $this->assertFalse($actual->valid);
        $this->assertSame(0, $actual->countryDiallingCode);
        $this->assertSame('', $actual->countryIdentifier);
        $this->assertSame('', $actual->mnoIdentifier);
        $this->assertSame('', $actual->subscriberNumber);
    }
}

<?php

namespace Msidn\Server;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberToCarrierMapper;

class Instance
{
    /**
     * PhoneNumberUtil dependency
     * @var PhoneNumberUtil
     */
    protected $numberUtil;

    /**
     * Carrier Mapper Dependecy
     * @var PhoneNumberToCarrierMapper
     */
    protected $carrierMapper;


    public $countryDiallingCode;
    public $countryIdentifier;
    public $mnoIdentifier;
    public $subscriberNumber;
    public $valid;


    /**
     * __construct
     * @param  PhoneNumberUtil $numberUtil
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function __construct(PhoneNumberUtil $numberUtil, PhoneNumberToCarrierMapper $carrierMapper)
    {
        $this->setCarrierMapper($carrierMapper);
        $this->setNumberUtil($numberUtil);
    }

    /**
     * Carrier Mapper Getter
     * @return PhoneNumberToCarrierMapper
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getCarrierMapper()
    {
        return $this->carrierMapper;
    }

    /**
     * Carrier Mapper Setter
     * @param  PhoneNumberToCarrierMapper $carrierMapper
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function setCarrierMapper(PhoneNumberToCarrierMapper $carrierMapper)
    {
        $this->carrierMapper = $carrierMapper;
    }

    /**
     * PhoneNumberUtil Getter
     * @return PhoneNumberUtil
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getNumberUtil()
    {
        return $this->numberUtil;
    }

    /**
     * PhoneNumberUtil Setter
     * @param  PhoneNumberUtil $numberUtil
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function setNumberUtil(PhoneNumberUtil $numberUtil)
    {
        $this->numberUtil = $numberUtil;
    }

    /**
     * Parse msisdn
     * @param  string $number
     * @return Instance
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function parse($number)
    {
        $phoneNumber = $this->numberUtil->parse($number, null);

        $this->countryDiallingCode = $phoneNumber->getCountryCode();
        $this->countryIdentifier = $this->numberUtil->getRegionCodeForNumber($phoneNumber);
        $this->mnoIdentifier = $this->carrierMapper->getNameForNumber($phoneNumber, 'en_US');
        $this->subscriberNumber = $phoneNumber->getNationalNumber();
        $this->valid = $this->numberUtil->isValidNumber($phoneNumber);

        return $this;
    }
}

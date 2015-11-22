<?php

namespace Msidn\Server;

use libphonenumber\PhoneNumberUtil;

class Instance
{
    /**
     * PhoneNumberUtil dependency
     * @var PhoneNumberUtil
     */
    protected $numberUtil;

    /**
     * Parsed Photo
     * @var PhoneNumber
     */
    protected $number;

    /**
     * __construct
     * @param  PhoneNumberUtil $numberUtil
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function __construct(PhoneNumberUtil $numberUtil)
    {
        $this->setNumberUtil($numberUtil);
    }

    /**
     * NumberUtil getter
     * @return PhoneNumberUtil
     * @author Andraz <andraz.krascek@gmail.com>
     */
    public function getNumberUtil()
    {
        return $this->numberUtil;
    }

    /**
     * PhoneNumberUtil setter
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
        $this->number = $this->numberUtil->parse($number);

        return $this
    }
}

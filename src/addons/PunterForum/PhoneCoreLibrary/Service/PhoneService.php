<?php

namespace PunterForum\PhoneCoreLibrary\Service;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use XF\Service\AbstractService;

class PhoneService extends AbstractService
{

    /**
     * Libphonenumber for PHP.
     *
     * @var PhoneNumberUtil
     */
    protected PhoneNumberUtil $phoneUtil;

    /**
     * @param \XF\App $app
     */
    public function __construct(\XF\App $app)
    {
        parent::__construct($app);
        $this->phoneUtil = PhoneNumberUtil::getInstance();
    }

    /**
     * @param string $string
     * @return array
     * @throws \Exception
     */
    public function getPhoneNumberFromString(string $string): array
    {
        $numbers = [];
        preg_match_all('/\\+?[1-9][0-9]{7,14}/', $string, $matches);
        if (!empty($matches[0]) && is_array($matches[0])) {
            foreach ($matches[0] as $number) {
                $numbers[] = $this->validatePhoneNumber($number);
            }
            return $numbers;
        } else {
            throw new \Exception('No phone number found');
        }
    }

    /**
     * @param string $string
     * @param array $phones
     * @return string
     */
    public function removePhoneFromString(string $string, array $phones): string
    {
        return trim(str_replace($phones, "", $string));
    }


    /**
     * @param string $phone
     * @return string
     */
    public function validatePhoneNumber(string $phone): string
    {
        try {
            assert(!empty($phone));

            $phoneNumberObject = $this->phoneUtil->parse($phone, "IT");
            assert($this->phoneUtil->isPossibleNumber($phoneNumberObject) === TRUE);
            assert($this->phoneUtil->getNumberType($phoneNumberObject) === PhoneNumberType::MOBILE);

            $regionCode = $this->phoneUtil->getRegionCodeForNumber($phoneNumberObject);
            assert($this->phoneUtil->isValidNumberForRegion($phoneNumberObject, $regionCode) === TRUE);

            return ($regionCode == "IT") ? $phoneNumberObject->getNationalNumber() : $this->phoneUtil->format($phoneNumberObject, PhoneNumberFormat::E164);

        } catch (\Throwable $t) {
            return $phone;
        }

    }

    /**
     * @param string $phoneNumber
     * @return string
     */
    public function formatPhoneNumber(string $phoneNumber): string
    {
        try {
            $regionCode = (substr($phoneNumber, 0, 1) !== "+") ? "IT" : NULL;
            $phoneNumberObject = $this->phoneUtil->parse($phoneNumber, $regionCode);
            $phone = $this->phoneUtil->format($phoneNumberObject, PhoneNumberFormat::E164);
        } catch (NumberParseException $e) {
            $phone = str_replace(array('+', ' '), array('0', ''), $phoneNumber);
        }

        return $phone;
    }

    /**
     * @param string $phoneNumber
     * @return string
     */
    public function getSearchablePhoneNumberString(string $phoneNumber): string
    {
        try {
            $phoneNumberObject = $this->phoneUtil->parse($phoneNumber, "IT");
            return ($this->phoneUtil->getRegionCodeForNumber($phoneNumberObject) === "IT") ?
                str_replace(" ", "", $phoneNumberObject->getNationalNumber()) :
                ltrim($this->phoneUtil->format($phoneNumberObject, PhoneNumberFormat::E164), "+");
        } catch (NumberParseException $e) {
            return str_replace(array('+', ' '), array('0', ''), $phoneNumber);
        }
    }
}
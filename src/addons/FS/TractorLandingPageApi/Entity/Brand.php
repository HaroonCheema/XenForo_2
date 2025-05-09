<?php

namespace FS\TractorLandingPageApi\Entity;

class Brand extends XFCP_Brand
{

    protected function setupApiResultData(\XF\Api\Result\EntityResult $result, $verbosity = self::VERBOSITY_NORMAL, array $options = [])
    {

        $result->brand_title = $this->brand_title;
    }
}

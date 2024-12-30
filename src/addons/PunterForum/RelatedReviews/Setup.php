<?php

namespace PunterForum\RelatedReviews;

use XF\AddOn\AbstractSetup;

class Setup extends AbstractSetup
{
    public function install(array $stepParams = [])
    {
        // Nothing to do yet
    }

    public function upgrade(array $stepParams = [])
    {
        // Nothing to do yet
    }

    public function uninstall(array $stepParams = [])
    {
        // Nothing to do yet
    }

    public function checkRequirements(&$errors = [], &$warnings = [])
    {
        $vendorDirectory = sprintf("%s/vendor", $this->addOn->getAddOnDirectory());
        if (!file_exists($vendorDirectory))
        {
            $errors[] = "vendor folder does not exist - cannot proceed with addon install";
        }
    }
}


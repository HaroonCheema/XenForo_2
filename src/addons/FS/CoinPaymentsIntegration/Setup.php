<?php

namespace FS\CoinPaymentsIntegration;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;
        
    public function installStep1() 
    {
        
        $providerClass = 'FS\CoinPaymentsIntegration:CoinPayments';
        $addonId = 'FS/CoinPaymentsIntegration';
         
        $sql = "INSERT INTO xf_payment_provider
				(provider_id, provider_class, addon_id)
			VALUES
				('coinpayments', ?, ?)";

        
        $this->db()->query($sql,[$providerClass, $addonId]);
         
    }
    
    public function uninstallStep1() 
    {
        $sql = "DELETE FROM xf_payment_provider WHERE provider_id='coinpayments'";
        $this->db()->query($sql);
    }
}
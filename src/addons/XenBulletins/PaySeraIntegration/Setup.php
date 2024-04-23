<?php

namespace XenBulletins\PaySeraIntegration;

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
        
        $providerClass = 'XenBulletins\PaySeraIntegration:PaySera';
         
        $sql = "INSERT INTO xf_payment_provider
				(provider_id, provider_class, addon_id)
			VALUES
				('paysera', ?, 'XenBulletins/PaySeraIntegration')";

         \XF::db()->query($sql,$providerClass);
         
    }
    
    public function uninstallStep1() 
    {
        $sql = "DELETE FROM xf_payment_provider WHERE provider_id='paysera'";
        \XF::db()->query($sql);
    }
}
<?php

namespace ThemeHouse\Monetize;

use ThemeHouse\Monetize\Setup\DefaultPopulator;
use ThemeHouse\Monetize\Setup\Install;
use ThemeHouse\Monetize\Setup\Patch1000041;
use ThemeHouse\Monetize\Setup\Patch1010070;
use ThemeHouse\Monetize\Setup\Patch1010370;
use ThemeHouse\Monetize\Setup\Patch1010670;
use ThemeHouse\Monetize\Setup\Patch1010770;
use ThemeHouse\Monetize\Setup\Uninstall;
use ThemeHouse\Monetize\XF\Repository\UserUpgrade;
use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

/**
 * Class Setup
 * @package ThemeHouse\Monetize
 */
class Setup extends AbstractSetup
{
    use StepRunnerInstallTrait;
    use StepRunnerUpgradeTrait;
    use StepRunnerUninstallTrait;
    use DefaultPopulator;

    use Install;
    use Uninstall;

    use Patch1000041;
    use Patch1010070;
    use Patch1010370;
    use Patch1010670;
    use Patch1010770;

    /**
     * @param $previousVersion
     * @param array $stateChanges
     * @throws \XF\PrintableException
     */
    public function postUpgrade($previousVersion, array &$stateChanges)
    {
        if ($this->applyDefaultPermissions($previousVersion)) {
            $this->app->jobManager()->enqueueUnique(
                'permissionRebuild',
                'XF:PermissionRebuild',
                [],
                false
            );
        }

        $this->createDefaultUpgradePage($previousVersion);
        $this->createDefaultPaymentProvider($previousVersion);
        $this->createDefaultPaymentProfile($previousVersion);
        $this->createDefaultAlert($previousVersion);
        $this->createDefaultEmail($previousVersion);
        $this->createDefaultMessage($previousVersion);

        /** @var UserUpgrade $userUpgradeRepo */
        $userUpgradeRepo = \XF::repository('XF:UserUpgrade');
        $userUpgradeRepo->generateCssForThMonetizeUserUpgrades();
    }
}

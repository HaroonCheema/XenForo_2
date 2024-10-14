<?php

namespace ThemeHouse\ThreadCredits\XF\Entity;

use ThemeHouse\ThreadCredits\Entity\UserCreditPackage;
use ThemeHouse\ThreadCredits\Repository\CreditPackage;
use XF\Mvc\Entity\Structure;

/**
 * @property int $thtc_credits_cache
 */
class User extends XFCP_User
{
    protected function getThtcCreditPackageRepo(): CreditPackage
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->repository('ThemeHouse\ThreadCredits:CreditPackage');
    }

    public function getThtcCreditsCache(): int
    {
        $creditPackageRepo = $this->getThtcCreditPackageRepo();
        $userCreditPackages = $creditPackageRepo->findUserCreditPackagesForUser($this)
            ->activeOnly()
            ->indexHint('FORCE', 'query_index')
            ->fetch();

        $totalCredits = 0;
        foreach ($userCreditPackages as $userCreditPackage) {
            /** @var UserCreditPackage $userCreditPackage */
            $totalCredits += $userCreditPackage->remaining_credits;
        }
        return $totalCredits;
    }

    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns += ['thtc_credits_cache' => ['type' => self::UINT, 'default' => 0]];

        $structure->getters += [
            'thtc_credits_cache' => true
        ];

        return $structure;
    }
}

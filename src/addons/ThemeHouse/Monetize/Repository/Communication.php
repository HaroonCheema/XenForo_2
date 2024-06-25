<?php

namespace ThemeHouse\Monetize\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

/**
 * Class AbstractCommunication
 * @package ThemeHouse\Monetize\Repository
 */
class Communication extends Repository
{
    /**
     * @return Finder
     */
    public function findForList()
    {
        return $this->finder('ThemeHouse\Monetize:Communication')
            ->order('communication_id');
    }
}
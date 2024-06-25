<?php

namespace ThemeHouse\Monetize\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int|null th_sponsor_id
 * @property string title
 * @property bool active
 * @property string url
 * @property string image
 * @property int width
 * @property int height
 * @property bool directory
 * @property str notes
 */
class Sponsor extends Entity
{
    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_th_monetize_sponsor';
        $structure->shortName = 'ThemeHouse\Monetize:Sponsor';
        $structure->primaryKey = 'th_sponsor_id';

        $structure->columns = [
            'th_sponsor_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
            'title' => [
                'type' => self::STR,
                'maxLength' => 150,
                'required' => 'please_enter_valid_title',
                'api' => true,
            ],
            'active' => ['type' => self::BOOL, 'default' => true, 'api' => true],
            'featured' => ['type' => self::BOOL, 'default' => false, 'api' => true],
            'url' => ['type' => self::STR, 'default' => '', 'api' => true],
            'image' => ['type' => self::STR, 'default' => '', 'api' => true],
            'width' => ['type' => self::UINT, 'default' => 0, 'api' => true],
            'height' => ['type' => self::UINT, 'default' => 0, 'api' => true],
            'directory' => ['type' => self::BOOL, 'default' => true, 'api' => true],
            'notes' => ['type' => self::STR, 'default' => '', 'api' => true],
        ];

        return $structure;
    }

    protected function setupApiResultData(
        \XF\Api\Result\EntityResult $result,
        $verbosity = self::VERBOSITY_NORMAL,
        array $options = []
    ) {

    }

    /**
     * @return \ThemeHouse\Monetize\Repository\Sponsor
     */
    protected function getSponsorRepo()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->repository('ThemeHouse\Monetize:Sponsor');
    }
}

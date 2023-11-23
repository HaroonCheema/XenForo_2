<?php

namespace Snog\TV\Entity;

use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int $tv_id
 * @property int $tv_season
 * @property int $tv_episode
 * @property int $person_id
 * @property string $credit_id
 * @property string $known_for_department
 * @property string $job
 * @property array $jobs
 * @property int $total_episode_count
 * @property int $order
 *
 * RELATIONS
 * @property TV $TV
 * @property Person $Person
 */
class Crew extends \XF\Mvc\Entity\Entity
{
	/**
	 * @param Structure $structure
	 * @return Structure
	 */
	public static function getStructure(Structure $structure)
	{
		$structure->table = 'xf_snog_tv_crew';
		$structure->shortName = 'Snog\TV:Crew';
		$structure->primaryKey = ['tv_id', 'tv_season', 'tv_episode', 'person_id'];
		$structure->columns = [
			'tv_id' => ['type' => static::UINT, 'required' => true],
			'tv_season' => ['type' => static::UINT, 'required' => true],
			'tv_episode' => ['type' => static::UINT, 'required' => true],
			'person_id' => ['type' => static::UINT, 'required' => true],
			'credit_id' => ['type' => static::STR, 'maxLength' => 24, 'required' => true],
			'known_for_department' => ['type' => static::STR, 'maxLength' => 255, 'default' => ''],
			'department' => ['type' => static::STR, 'maxLength' => 255, 'default' => ''],
			'job' => ['type' => static::STR, 'maxLength' => 255, 'default' => ''],
			'jobs' => ['type' => static::JSON_ARRAY, 'nullable' => true, 'default' => []],
			'total_episode_count' => ['type' => static::UINT, 'default' => 0],
			'order' => ['type' => static::UINT, 'default' => 0],
		];

		$structure->relations = [
			'TV' => [
				'entity' => 'Snog\TV:TV',
				'type' => self::TO_ONE,
				'conditions' => [
					['tv_id', '=', '$tv_id'],
					['tv_season', '=', '$tv_season'],
					['tv_episode', '=', '$tv_episode'],
				],
				'primary' => true
			],
			'Person' => [
				'entity' => 'Snog\TV:Person',
				'type' => self::TO_ONE,
				'conditions' => 'person_id',
				'primary' => true
			],
		];

		return $structure;
	}
}
<?php


namespace OzzModz\Badges\Job;


class MasterPhrasesMerge extends \XF\Job\AbstractRebuildJob
{
	protected $defaultData = [
		'source_language_id' => null,
		'delete_source_phrases' => false
	];

	public function run($maxRunTime)
	{
		if (!$this->data['source_language_id'])
		{
			throw new \LogicException('Please provide source_language_id');
		}

		return parent::run($maxRunTime);
	}

	protected function getNextIds($start, $batch)
	{
		$sourceLangId = $this->data['source_language_id'];
		$db = $this->app->db();

		return $db->fetchAllColumn($db->limit(
			"
				SELECT phrase_id
				FROM xf_phrase
				WHERE (
				    xf_phrase.title LIKE 'ozzmodz_badges_badge_alt_description.%'
					OR xf_phrase.title LIKE 'ozzmodz_badges_badge_title.%'
					OR xf_phrase.title LIKE 'ozzmodz_badges_badge_description.%'
				    OR xf_phrase.title LIKE 'ozzmodz_badges_badge_category_title.%'
				    OR xf_phrase.title LIKE 'ozzmodz_badges_badge_tier_title.%'
				)
				AND language_id = ?
				AND phrase_id > ?
				ORDER BY phrase_id
			", $batch
		),[$sourceLangId, $start]);
	}

	protected function rebuildById($id)
	{
		/** @var \XF\Entity\Phrase $phrase */
		$phrase = $this->app->em()->find('XF:Phrase', $id);
		if (!$phrase || $phrase->language_id == 0)
		{
			return;
		}

		/** @var \XF\Entity\Phrase $masterPhrase */
		$masterPhrase = $phrase->getRelationOrDefault('Master');
		if (!empty($masterPhrase->addon_id))
		{
			return;
		}

		$masterPhrase->phrase_text = $phrase->phrase_text;
		$masterPhrase->saveIfChanged();

		if ($this->data['delete_source_phrases'])
		{
			$phrase->delete();
		}
	}

	protected function getStatusType()
	{
		return \XF::phrase('phrases');
	}
}
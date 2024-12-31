<?php

namespace OzzModz\Badges\Cli\Command\Rebuild;

use Symfony\Component\Console\Input\InputOption;

class MasterPhrasesMerge extends \XF\Cli\Command\Rebuild\AbstractRebuildCommand
{
	/**
	 * @inheritDoc
	 */
	protected function getRebuildName()
	{
		return 'ozzmodz-badges-master-phrase-merge';
	}

	protected function getRebuildDescription()
	{
		return 'Merges phrases from selected language into the master language';
	}

	protected function getRebuildClass()
	{
		return '\OzzModz\Badges:MasterPhrasesMerge';
	}

	protected function configureOptions()
	{
		$this
			->addOption(
				'source_language_id',
				null,
				InputOption::VALUE_REQUIRED,
				'Source language for merge into master'
			)
			->addOption(
				'delete_source_phrases',
				null,
				InputOption::VALUE_NONE,
				'Delete the source phrases after merging'
			);
	}
}
<?php
namespace MJCore;

use XF\AddOn\AbstractSetup AS XFAbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Util\Arr;

abstract class AbstractSetup extends XFAbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	protected $addOnType;

	public function installStep1()
	{
		$sm = $this->schemaManager();

		foreach ($this->getTables() AS $tableName => $closure)
		{
			$sm->createTable($tableName, $closure);
		}
	}

	public function installStep2()
	{
		$sm = $this->schemaManager();
		foreach ($this->getAlters() AS $tableName => $closure)
		{
			$sm->alterTable($tableName, $closure);
		}
	}

	public function uninstallStep1()
	{
		$sm = $this->schemaManager();

		foreach (array_keys($this->getTables()) AS $tableName)
		{
			$sm->dropTable($tableName);
		}
	}

	public function postInstall(array &$stateChanges)
	{
		$this->removeDefaultCodeEventListeners();
		$this->importDefaultCodeEventListeners();
	}

	public function postUpgrade($previousVersion, array &$stateChanges)
	{
		$this->removeDefaultCodeEventListeners();
		$this->importDefaultCodeEventListeners();
	}

	public function uninstallStep2()
	{
		$sm = $this->schemaManager();
		foreach ($this->getDropAlters() AS $tableName => $closure)
		{
			$sm->alterTable($tableName, $closure);
		}
	}

	protected function removeDefaultCodeEventListeners()
	{
		if($this->addOnType == 'customer')
		{
			return;
		}
		$filter = ['addon_id', 'event_id', 'callback_class', 'callback_method', 'hint'];
		foreach($this->getDefaultRemoveCodeEventListeners() as $listenerData)
		{
			$where = Arr::arrayFilterKeys($listenerData, $filter, true);
			$listener = \XF::em()->getFinder('XF:CodeEventListener')->where($where)->fetchOne();
			if(!$listener)
			{
				continue;
			}
			$listener->delete();
		}
	}

	protected function importDefaultCodeEventListeners()
	{
		if($this->addOnType == 'customer')
		{
			return;
		}
		$filter = ['addon_id', 'event_id', 'callback_class', 'callback_method', 'hint'];
		foreach($this->getDefaultCodeEventListeners() as $listenerData)
		{
			$where = Arr::arrayFilterKeys($listenerData, $filter, true);
			$listener = \XF::em()->getFinder('XF:CodeEventListener')->where($where)->fetchOne();
			if($listener)
			{
				continue;
			}

			$listener = \XF::em()->create('XF:CodeEventListener');
			$listener->bulkSet($listenerData);
			$listener->save();
		}
	}

	protected function getDefaultRemoveCodeEventListeners()
	{
		$listeners[] = [
			'event_id' => 'templater_setup',
			'execute_order' => 9999,
			'callback_class' => 'Brivium\Library\Listener',
			'callback_method' => 'templaterSetup',
			'active' => 1,
			'addon_id' => '',
			'hint' => '',
		];
		return $listeners;
	}

	protected function getDefaultCodeEventListeners()
	{
		$listeners[] = [
			'event_id' => 'templater_setup',
			'execute_order' => 9999,
			'callback_class' => 'MJCore\Listener',
			'callback_method' => 'templaterSetup',
			'active' => 1,
			'addon_id' => '',
			'hint' => '',
		];
		return $listeners;
	}

	protected function getTables()
	{
		$tables = [];

		// {$renderTables}

		return $tables;
	}

	protected function getAlters()
	{
		$alters = [];

		// {$renderAlters}

		return $alters;
	}

	protected function getDropAlters()
	{
		$alters = [];

		// {$renderAlters}

		return $alters;
	}
}
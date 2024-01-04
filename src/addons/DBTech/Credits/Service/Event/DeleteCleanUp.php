<?php

namespace DBTech\Credits\Service\Event;

/**
 * Class DeleteCleanUp
 *
 * @package DBTech\Credits\Service\Event
 */
class DeleteCleanUp extends \XF\Service\AbstractService
{
	use \XF\MultiPartRunnerTrait;
	
	/** @var int */
	protected $eventId;

	/** @var string */
	protected $title;
	
	/** @var string[]  */
	protected $steps = [
		'stepDeleteTransactions',
	];
	
	
	/**
	 * DeleteCleanUp constructor.
	 *
	 * @param \XF\App $app
	 * @param int $eventId
	 * @param string $title
	 */
	public function __construct(\XF\App $app, int $eventId, string $title)
	{
		parent::__construct($app);
		
		$this->eventId = $eventId;
		$this->title = $title;
	}
	
	/**
	 * @return array
	 */
	protected function getSteps(): array
	{
		return $this->steps;
	}
	
	/**
	 * @param int $maxRunTime
	 *
	 * @return \XF\ContinuationResult
	 */
	public function cleanUp(int $maxRunTime = 0): \XF\ContinuationResult
	{
		$this->db()->beginTransaction();
		$result = $this->runLoop($maxRunTime);
		$this->db()->commit();
		
		return $result;
	}
	
	/**
	 * @param int|null $lastOffset
	 * @param int|null $maxRunTime
	 *
	 * @return int|null
	 * @throws \InvalidArgumentException
	 * @throws \LogicException
	 * @throws \XF\PrintableException
	 */
	protected function stepDeleteTransactions(?int $lastOffset, ?int $maxRunTime): ?int
	{
		$start = microtime(true);
		
		/** @var \DBTech\Credits\Entity\Transaction[] $transactions */
		$finder = $this->finder('DBTech\Credits:Transaction')
			->where('event_id', $this->eventId)
			->order('transaction_id');
		
		if ($lastOffset !== null)
		{
			$finder->where('transaction_id', '>', $lastOffset);
		}
		
		$maxFetch = 1000;
		$transactions = $finder->fetch($maxFetch);
		$fetchedTransactions = count($transactions);
		
		if (!$fetchedTransactions)
		{
			return null; // done or nothing to do
		}
		
		foreach ($transactions AS $transaction)
		{
			$lastOffset = $transaction->transaction_id;
			
//			$transaction->setOption('log_moderator', false);
			$transaction->delete();
			
			if ($maxRunTime && microtime(true) - $start > $maxRunTime)
			{
				return $lastOffset; // continue at this position
			}
		}
		
		if ($fetchedTransactions == $maxFetch)
		{
			return $lastOffset; // more to do
		}
		
		return null;
	}
}
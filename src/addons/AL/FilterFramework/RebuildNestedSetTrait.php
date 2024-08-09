<?php
/** 
* @package [AL] Filter Framework
* @author AddonsLab
* @license https://addonslab.com/
* @link https://addonslab.com/
* @version 1.2.1
This software is furnished under a license and may be used and copied
only  in  accordance  with  the  terms  of such  license and with the
inclusion of the above copyright notice.  This software  or any other
copies thereof may not be provided or otherwise made available to any
other person.  No title to and  ownership of the  software is  hereby
transferred.                                                         
                                                                     
You may not reverse  engineer, decompile, defeat  license  encryption
mechanisms, or  disassemble this software product or software product
license.  AddonsLab may terminate this license if you don't comply with
any of these terms and conditions.  In such event,  licensee  agrees 
to return licensor  or destroy  all copies of software  upon termination 
of the license.
*/


namespace AL\FilterFramework;

use XF\Mvc\Entity\Entity;

trait RebuildNestedSetTrait
{
    /**
     * @var \AL\FilterFramework\Repository\Logger
     */
    protected $logger;

    protected function setLogger(\AL\FilterFramework\Repository\Logger $logger)
    {
        $this->logger = $logger;
    }

    protected function _isValidEntity($entity)
    {
        // TODO test if this check is needed at all
        return true;
        if (is_string($entity))
        {
            return $entity === $this->_getCategoryEntityName();
        }
        elseif (is_object($entity))
        {
            $className = $this->_getCategoryEntityName();
            return ($entity instanceof $className);
        }

        return false;
    }

    protected function getBasePassableData()
    {
        $data = parent::getBasePassableData();

        if (!$this->_isValidEntity($this->entityType))
        {
            return $data;
        }

        $data['effective_filter_location'] = '';

        return $data;
    }

    protected function getSelfData(array $passData, Entity $entity, $depth, $left)
    {
        $passData = parent::getSelfData($passData, $entity, $depth, $left);

        if (!$this->_isValidEntity($entity))
        {
            $this->_logMessage(\Monolog\Logger::DEBUG, 'Entity type is invalid - ' . $this->entityType);
            return $passData;
        }

        $this->_logMessage(\Monolog\Logger::DEBUG, 'Rebuilding data of entity ' . $this->entityType . ' with ID ' . $entity->getEntityId());
        try
        {
            if ($entity->filter_location)
            {
                $this->_logMessage(\Monolog\Logger::DEBUG, 'Entity has filter location set to ' . $entity->filter_location);
                $passData['effective_filter_location'] = $entity->filter_location;
            }
            else
            {
                $this->_logMessage(\Monolog\Logger::DEBUG, 'Entity has no filter location set');
            }
        }
        catch (\ErrorException $exception)
        {
            $this->_logMessage(\Monolog\Logger::DEBUG, 'Error while getting filter location: ' . $exception->getMessage());
            // for types not supported for now
            $passData['effective_filter_location'] = '';
        }

        return $passData;
    }

    protected function getChildPassableData(array $passData, Entity $entity, $depth, $left)
    {
        $passData = parent::getChildPassableData($passData, $entity, $depth, $left);

        if (!$this->_isValidEntity($entity))
        {
            $this->_logMessage(\Monolog\Logger::DEBUG, 'Entity type is invalid - ' . $this->entityType);
            return $passData;
        }

        $this->_logMessage(\Monolog\Logger::DEBUG, 'Rebuilding children data of entity ' . $this->entityType . ' with ID ' . $entity->getEntityId());
        try
        {
            if ($entity->filter_location)
            {
                $this->_logMessage(\Monolog\Logger::DEBUG, 'Entity has filter location set to ' . $entity->filter_location);
                $passData['effective_filter_location'] = $entity->filter_location;
            }
            else
            {
                $this->_logMessage(\Monolog\Logger::DEBUG, 'Entity has no filter location set');
            }
        }
        catch (\ErrorException $exception)
        {
            $this->_logMessage(\Monolog\Logger::DEBUG, 'Error while getting filter location: ' . $exception->getMessage());
            // for types not supported for now
            $passData['effective_filter_location'] = '';
        }

        return $passData;
    }

    protected function _logMessage($level, $message, array $context = array())
    {
        if ($this->logger)
        {
            $this->logger->logMessage($level, $message, $context);
        }
    }
}
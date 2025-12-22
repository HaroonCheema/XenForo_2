<?php

namespace EWR\Porta\Listener;

class Importer
{
    public static function importImporterClass(\XF\SubContainer\Import $container, \XF\Container $parentContainer, array &$importers)
    {
		$importers[] = 'EWR\Porta:Porta100';
		$importers[] = 'EWR\Porta:Porta121';
    }
}
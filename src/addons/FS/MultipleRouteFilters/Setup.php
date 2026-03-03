<?php

namespace FS\MultipleRouteFilters;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	// $parts = explode('/', $routePath, 2);
	// 	$prefix = $parts[0];

	// 	$routePath = $this->getRouter()->applyMultiRouteFilterToUrl($prefix, $routePath);


	// 	public function applyMultiRouteFilterToUrl($prefix, $routeUrl)
	// {
	// 	$filters = $this->routeFiltersOut;

	// 	if (isset($filters[$prefix])) {
	// 		if (!isset($this->routeFiltersOutRegex[$prefix])) {
	// 			$regexes = [];

	// 			foreach ($filters[$prefix] as $filter) {
	// 				list($from, $to) = $this->routeFilterToRegex(
	// 					$filter['find_route'],
	// 					$filter['replace_route']
	// 				);
	// 				$regexes[] = ['from' => $from, 'to' => $to];
	// 			}

	// 			$this->routeFiltersOutRegex[$prefix] = $regexes;
	// 		}

	// 		foreach ($this->routeFiltersOutRegex[$prefix] as $filter) {
	// 			$newLink = preg_replace($filter['from'], $filter['to'], $routeUrl);
	// 			if ($newLink != $routeUrl) {
	// 				$routeUrl = $newLink;
	// 				break;
	// 			}
	// 		}
	// 	}

	// 	// ✅ NEW: After replacement, extract new prefix and check if it also has filters
	// 	// Keep looping until no more replacements happen (chain following)
	// 	$maxIterations = 10; // safety limit to avoid infinite loops
	// 	$iteration = 0;

	// 	while ($iteration < $maxIterations) {
	// 		$iteration++;

	// 		// Extract new prefix from the current $routeUrl (part before first '/')
	// 		$newPrefix = strstr($routeUrl, '/', true);

	// 		if ($newPrefix === false || $newPrefix === $prefix) {
	// 			// No slash found or same prefix — stop
	// 			break;
	// 		}

	// 		if (!isset($filters[$newPrefix])) {
	// 			// New prefix has no filters — stop
	// 			break;
	// 		}

	// 		// Build regex for new prefix if not cached
	// 		if (!isset($this->routeFiltersOutRegex[$newPrefix])) {
	// 			$regexes = [];
	// 			foreach ($filters[$newPrefix] as $filter) {
	// 				list($from, $to) = $this->routeFilterToRegex(
	// 					$filter['find_route'],
	// 					$filter['replace_route']
	// 				);
	// 				$regexes[] = ['from' => $from, 'to' => $to];
	// 			}
	// 			$this->routeFiltersOutRegex[$newPrefix] = $regexes;
	// 		}

	// 		$replaced = false;
	// 		foreach ($this->routeFiltersOutRegex[$newPrefix] as $filter) {
	// 			$newLink = preg_replace($filter['from'], $filter['to'], $routeUrl);
	// 			if ($newLink != $routeUrl) {
	// 				$routeUrl = $newLink;
	// 				$prefix = $newPrefix; // update prefix for next iteration check
	// 				$replaced = true;
	// 				break;
	// 			}
	// 		}

	// 		if (!$replaced) {
	// 			// No replacement happened for this prefix — stop
	// 			break;
	// 		}
	// 	}

	// 	// echo "<pre>";
	// 	// var_dump($routeUrl);	
	// 	// exit;

	// 	return $routeUrl;
	// }
}

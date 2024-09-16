<?php
namespace MJCore;
class Helpers
{
	public static function requireLibrary($filePath)
	{
		$filePath = realpath($filePath);
		$dir = dirname($filePath);
		$fileName = basename($filePath);

		$folders = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::CATCH_GET_CHILD);

		$versions = [];
		foreach($folders as $folder)
		{
			if($folder->isDir() && is_numeric($folder->getFilename()))
			{
				$versions[$folder->getFilename()] = $folder->getPathname();
			}
		}
		krsort($versions);

		foreach($versions as $versionPath)
		{
			$files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($versionPath, \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST);
			foreach($files as $file)
			{
				if($file->getBasename() == $fileName && $file->getExtension() == 'php')
				{
					require_once($file->getPathname());
					return;
				}
			}
		}

	}
}
<?php

function unittestLoader($className)
{
	$originFileName = str_replace('\\', '/', $className);

	$fileName = str_replace('Templates', __DIR__ . '/../tests/Mocks', $originFileName);
	$fileName .= '.php';
	if (file_exists($fileName))
	{
		require_once $fileName;
		return;
	}

	$fileName = str_replace('Templates', __DIR__ . '/../src', $originFileName);
	$fileName .= '.php';
	if (file_exists($fileName))
	{
		require_once $fileName;
		return;
	}
}

function NoFileFoundLoader($className)
{
//	echo "**** no found ".__DIR__."/$className *****\r\n";
	throw new \Exception("Klasse $className konnte nicht geladen werden!");
}


spl_autoload_register('unittestLoader');
spl_autoload_register('NoFileFoundLoader');



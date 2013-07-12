<?php

function unittestLoader($className)
{
	$fileName = str_replace('\\', '/', $className);
	$fileName = str_replace('Templates', __DIR__ . '/../src', $fileName);
	$fileName .= '.php';
	if (file_exists($fileName))
	{
		require_once $fileName;
	}
}

function NoFileFoundLoader($className)
{
//	echo "**** no found ".__DIR__."/$className *****\r\n";
	throw new \Exception("Klasse $className konnte nicht geladen werden!");
}


spl_autoload_register('unittestLoader');
spl_autoload_register('NoFileFoundLoader');



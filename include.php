<?php
require __DIR__ . '/vendor/autoload.php';

use Ion\Ion;
use Ion\Settings;
use Ion\ComponentInterface;
use Ion\ReactHelper;
use Ion\ReactComponent;
use Ion\TwigHelper;
use Ion\TwigComponent;
use Bitrix\Main\Loader;

define('ION_SETTINGS_ID', 1);

Loader::registerAutoLoadClasses('ion', array(
	'\\' . Ion::class => './classes/Ion.php',
	'\\' . Settings::class => './classes/Settings.php',
	'\\' . ComponentInterface::class => './classes/ComponentInterface.php',
	'\\' . TwigHelper::class => './classes/TwigHelper.php',
	'\\' . TwigComponent::class => './classes/TwigComponent.php',
	'\\' . ReactHelper::class => './classes/ReactHelper.php',
	'\\' . ReactComponent::class => './classes/ReactComponent.php',
));

$SERVER_NAME_ARR = explode(".", strtoupper($_SERVER["SERVER_NAME"]));
$SERVER_NAME_ARR_REV = array_reverse($SERVER_NAME_ARR);
$GLOBALS["DOMAIN_FIRST"] = $SERVER_NAME_ARR_REV[0];
$GLOBALS["DOMAIN_SECOND"] = $SERVER_NAME_ARR_REV[1];
$GLOBALS["DOMAIN_THIRD"] = $SERVER_NAME_ARR_REV[2];
$GLOBALS["DOMAIN_FOURTH"] = $SERVER_NAME_ARR_REV[3];
$GLOBALS["DOMAIN_FIFTH"] = $SERVER_NAME_ARR_REV[4];

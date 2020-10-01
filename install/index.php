<?php

/**
 * @module ion
 */
class ion extends CModule
{
	var $MODULE_ID = "ion";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	
	function __construct()
	{
		$this->MODULE_VERSION = "1.2.0";
		$this->MODULE_VERSION_DATE = "2020-10-01 12:00";
		$this->MODULE_NAME = "ION";
		$this->MODULE_DESCRIPTION = "Sources: github.com/amensum/ion";
	}
	
	function InstallFiles()
	{
//		CopyDirFiles(
//			$_SERVER["DOCUMENT_ROOT"]."/local/modules/ion/install/components",
//			$_SERVER["DOCUMENT_ROOT"]."/local/components",
//			true,
//			true
//		);
		return true;
	}
	
	function UnInstallFiles()
	{
//		DeleteDirFilesEx("/local/components/ion");
		return true;
	}
	
	function DoInstall()
	{
		global $DOCUMENT_ROOT, $APPLICATION;
		$this->InstallFiles();
		
		// <EVENTS>
		$eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->registerEventHandler("main", "OnProlog", $this->MODULE_ID, "\Ion\Ion", "connectOnProlog");
        $eventManager->registerEventHandler("main", "OnEpilog", $this->MODULE_ID, "\Ion\Ion", "connectOnEpilog");
        $eventManager->registerEventHandler("main", "OnAfterEpilog", $this->MODULE_ID, "\Ion\Ion", "connectOnAfterEpilog");
		// </EVENTS>
		
		RegisterModule($this->MODULE_ID);
	}
	
	function DoUninstall()
	{
		global $DOCUMENT_ROOT, $APPLICATION;
		$this->UnInstallFiles();
		
		// <EVENTS>
		$eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->unRegisterEventHandler("main", "OnProlog", $this->MODULE_ID, "\Ion\Ion", "connectOnProlog");
        $eventManager->unRegisterEventHandler("main", "OnEpilog", $this->MODULE_ID, "\Ion\Ion", "connectOnEpilog");
        $eventManager->unRegisterEventHandler("main", "OnAfterEpilog", $this->MODULE_ID, "\Ion\Ion", "connectOnAfterEpilog");
		// </EVENTS>
		
		UnRegisterModule($this->MODULE_ID);
	}
}
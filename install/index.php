<?php

use Ion\Ion as I;
use Bitrix\Main\EventManager;

/**
 * Class IonModule
 * @module Ion
 */
class Ion extends CModule
{
	public $MODULE_ID = "ion";
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_NAME;
	public $MODULE_DESCRIPTION;
	public $MODULE_DIR;

	/**
	 * Ion constructor.
	 */
	public function __construct()
	{
		$this->MODULE_VERSION = "1.5.4";
		$this->MODULE_VERSION_DATE = "2020-11-26 12:30";
		$this->MODULE_NAME = "ION";
		$this->MODULE_DESCRIPTION = "Sources: github.com/amensum/ion";
		$this->MODULE_DIR = dirname(__DIR__);
	}

	/**
	 * @return bool
	 */
	public function InstallFiles(): bool
	{
		// Admin
		CopyDirFiles(
			$this->MODULE_DIR . "/install/admin",
			$_SERVER["DOCUMENT_ROOT"] . "/bitrix/admin",
		);

		// Icons
		CopyDirFiles(
			$this->MODULE_DIR . "/install/themes/.default/icons/" . $this->MODULE_ID,
			$_SERVER["DOCUMENT_ROOT"] . "/bitrix/themes/.default/icons/" . $this->MODULE_ID,
		);

		// Styles
		CopyDirFiles(
			$this->MODULE_DIR . "/install/themes/.default",
			$_SERVER["DOCUMENT_ROOT"] . "/bitrix/themes/.default",
		);

		return true;
	}

	/**
	 * @return bool
	 */
	public function UnInstallFiles(): bool
	{
		// Admin
		DeleteDirFiles(
			$this->MODULE_DIR . "/install/admin",
			$_SERVER["DOCUMENT_ROOT"] . "/bitrix/admin",
		);

		// Icons
		DeleteDirFiles(
			$this->MODULE_DIR . "/install/themes/.default/icons/" . $this->MODULE_ID,
			$_SERVER["DOCUMENT_ROOT"] . "/bitrix/themes/.default/icons/" . $this->MODULE_ID,
		);

		// Styles
		DeleteDirFiles(
			$this->MODULE_DIR . "/install/themes/.default",
			$_SERVER["DOCUMENT_ROOT"] . "/bitrix/themes/.default",
		);

		return true;
	}

	/**
	 * @return void
	 */
	public function DoInstall(): void
	{
		// global $DOCUMENT_ROOT, $APPLICATION;
		$this->InstallFiles();

		$eventManager = EventManager::getInstance();
		$eventManager->registerEventHandler("main", "OnProlog", $this->MODULE_ID, I::class, "connectOnProlog");
		$eventManager->registerEventHandler("main", "OnEpilog", $this->MODULE_ID, I::class, "connectOnEpilog");
		$eventManager->registerEventHandler("main", "OnAfterEpilog", $this->MODULE_ID, I::class, "connectOnAfterEpilog");

		RegisterModule($this->MODULE_ID);
	}

	/**
	 * @return void
	 */
	public function DoUninstall(): void
	{
		// global $DOCUMENT_ROOT, $APPLICATION;
		$this->UnInstallFiles();

		$eventManager = EventManager::getInstance();
		$eventManager->unRegisterEventHandler("main", "OnProlog", $this->MODULE_ID, I::class, "connectOnProlog");
		$eventManager->unRegisterEventHandler("main", "OnEpilog", $this->MODULE_ID, I::class, "connectOnEpilog");
		$eventManager->unRegisterEventHandler("main", "OnAfterEpilog", $this->MODULE_ID, I::class, "connectOnAfterEpilog");

		UnRegisterModule($this->MODULE_ID);
	}
}
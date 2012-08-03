<?
class bx_ichannels extends CModule {

	public $MODULE_ID = 'bx_ichannels';
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_NAME = 'IChannels';
	public $MODULE_DESCRIPTION = 'Imports data to iblocks from various sources';
	public $MODULE_GROUP_RIGHTS = 'Y';

	public function __construct() {
		include(dirname(__FILE__) . '/version.php');
		$this->MODULE_VERSION = $arModuleVersion['VERSION'];
		$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
	}

	public function DoInstall() {
		RegisterModule($this->MODULE_ID);
		CopyDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/bx_ichannels/install/admin', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin');
		RegisterModuleDependences('bx_ichannels', 'getImporters', 'bx_ichannels', 'CIChannelsRss', 'getImporter');
		RegisterModuleDependences('bx_ichannels', 'getRssMappers', 'bx_ichannels', 'CIChannelsRssMapperDefault', 'getRssMapper');
	}

	public function DoUninstall() {
		COption::RemoveOption($this->MODULE_ID);
		UnRegisterModule($this->MODULE_ID);
		DeleteDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/bx_ichannels/install/admin', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin');
	}
}
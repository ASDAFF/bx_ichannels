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
		global $APPLICATION, $DB, $DBType;

		RegisterModule($this->MODULE_ID);
		
		CopyDirFiles(
			$_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/bx_ichannels/install/admin', 
			$_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin'
		);

		CopyDirFiles(
			$_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/bx_ichannels/install/js', 
			$_SERVER['DOCUMENT_ROOT'] . '/bitrix/js/bx_ichannels', 
			/* rewrite = */true, 
			/* recoursive = */true
		);

		RegisterModuleDependences(
			'bx_ichannels', 
			'getImporters', 
			'bx_ichannels', 
			'CIChannelsRss', 
			'getImporter'
		);

		RegisterModuleDependences(
			'bx_ichannels', 
			'getRssMappers', 
			'bx_ichannels', 
			'CIChannelsRssMapperDefault', 
			'getRssMapper'
		);

		$this->errors = $DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/bx_ichannels/install/db/' . $DBType . '/install.sql');

		if ($this->errors) {
			$APPLICATION->ThrowException(implode('', $this->errors));
			return false;
		} else {
			return true;
		}
	}

	public function DoUninstall() {
		global $DB, $DBType;

		COption::RemoveOption($this->MODULE_ID);
		UnRegisterModule($this->MODULE_ID);
		DeleteDirFiles(
			$_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/bx_ichannels/install/admin', 
			$_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin'
		);
		DeleteDirFiles(
			$_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/bx_ichannels/install/js', 
			$_SERVER['DOCUMENT_ROOT'] . '/bitrix/js/bx_ichannels'
		);
		$this->errors = $DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/bx_ichannels/install/db/' . $DBType . '/uninstall.sql');
	}
}
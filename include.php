<?
foreach (new RecursiveDirectoryIterator($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/bx_ichannels/classes/general', FileSystemIterator::SKIP_DOTS) as $pathInfo) {
	if ($pathInfo->getExtension() == 'php') {
		require_once($pathInfo->getRealPath());
	}
}
?>
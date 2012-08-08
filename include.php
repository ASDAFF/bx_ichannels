<?
$classes_subdirs = array(
	'general',
	'mysql',
);
foreach ($classes_subdirs as $subdir) {
	foreach (
		new RecursiveDirectoryIterator(
			$_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/bx_ichannels/classes/' . $subdir, 
			FileSystemIterator::SKIP_DOTS
			) 
		as $pathInfo
		) {
		if ($pathInfo->getExtension() == 'php') {
			require_once($pathInfo->getRealPath());
		}
	}
}
?>
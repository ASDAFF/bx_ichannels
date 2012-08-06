<?
class CIChannels {

	public static function getEventResult($sEventName) {
		$rInfo = GetModuleEvents('bx_ichannels', $sEventName);
		$arResult = array();
		while (false != ($info = $rInfo->GetNext())) {
			$arResult[] = ExecuteModuleEvent($info);
		}
		return $arResult;
	}

	public static function getImporters() {
		return static::getEventResult('getImporters');
	}

	public static function getRssMappers() {
		return static::getEventResult('getRssMappers');
	}
}
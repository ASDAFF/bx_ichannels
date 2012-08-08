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

	public static function getRssMapperByID($id) {
		foreach (static::getRssMappers() as $mapper) {
			if ($mapper['id'] == $id) return $mapper;
		}
		return false;
	}
}
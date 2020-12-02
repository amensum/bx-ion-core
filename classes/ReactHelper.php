<?php

namespace Ion;

use Bitrix\Main\Page\Asset;
use JsonException;

class ReactHelper
{
	private static $registry;

	public function __construct()
	{
		self::$registry = array();
	}

	public static function import(string $path): void
	{
		global $DOCUMENT_ROOT;

		$els = scandir($DOCUMENT_ROOT . $path);

		foreach ($els as $file) {
			$matches = array();
			preg_match("/^(.*)\.(.*)$/", $file, $matches);
			[$full, $name, $ext] = $matches;

			if (self::$registry[$name] === null && $ext === "js") {
				self::$registry[$name] = true;

				$asset_inst = Asset::getInstance();
				$asset_inst->addString("<script type=\"text/babel\" src=\"$path/$file\"></script>");
			}
		}
	}

	public static function render(string $name, array $params = []): string
	{
		if (self::$registry[$name] === true) {
			$id = uniqid("react_", false);

			try {
				$props = json_encode($params, JSON_THROW_ON_ERROR);

				return <<< JS
				<script id="$id" type="text/babel">
					ReactDOM.render(<$name {...$props}/>, document.querySelector("#$id"), () => {
						const parent = document.querySelector("#$id");
						const firstChild = parent.childNodes[0];
						parent.replaceWith(firstChild);
					});
				</script>
				JS;
			} catch (JsonException $e) {
				return $e->getMessage();
			}
		}

		return false;
	}
}
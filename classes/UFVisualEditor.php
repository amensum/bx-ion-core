<?php

namespace Ion;

use \CFileMan;

/**
 * Class UFVisualEditor
 * @package Ion
 */
final class UFVisualEditor
{
    public function GetUserTypeDescription(): ?array
    {
        return [
            "CLASS_NAME" => self::class,
            "BASE_TYPE" => "string",
            "USER_TYPE_ID" => "ion_visual_editor_field",
            "DESCRIPTION" => "Визуальный редактор (ion)"
        ];
    }

    public function GetDBColumnType(): ?string
    {
        return "text";
    }

    public function GetEditFormHTML($arUserField, $arHtmlControl): ?string
    {
        ob_start();
        CFileMan::AddHTMLEditorFrame(
            $arHtmlControl["NAME"],
            $arHtmlControl["VALUE"],
            false,
            "html",
            ["height" => "120"]
        );
        return ob_get_clean();
    }
}
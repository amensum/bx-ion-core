<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php"); ?>

<?php
/**
 * @global $APPLICATION
 * @global $USER
 * @var $USER_FIELD_MANAGER
 * @var $REQUEST_METHOD
 * @var $table_id
 * @var $by
 * @var $order
 */

if (!$USER->IsAdmin()) {
    return;
}

use \Ion\Settings;

$cur_page_url = urlencode($APPLICATION->GetCurPage());

$install_status = CModule::IncludeModuleEx("ion");
$settings = new Settings();
$spaces = Settings::getSpaces();

$ca_sorting = new CAdminSorting("spaces_list", "ID", "DESC");
$ca_list = new CAdminList("spaces_list", $ca_sorting);

$ca_list->AddHeaders(array(
    array(
        "id" => "NAME",
        "content" => "Название",
        "default" => true
    ),
    array(
        "id" => "CODE",
        "content" => "Символьный код",
        "default" => true
    ),
    array(
        "id" => "EXAMPLE",
        "content" => "Пример кода",
        "default" => true
    )
));

$spaces_list_order = array();

if ($table_id === "spaces_list") {
    $spaces_list_order[$by] = $order;
}

foreach ($spaces as $i => $space) {
    $row = &$ca_list->AddRow($i, array(
        "NAME" => $space["NAME"],
        "CODE" => $space["CODE"],
        "EXAMPLE" => "Ion\Settings::getSpaceField(\"UF_FIELD\", \"{$space["CODE"]}\");"
    ));
    $row->AddActions(array(
        array(
            "DEFAULT" => true,
            "ICON" => "edit",
            "TEXT" => "Изменить",
            "ACTION" => $ca_list->ActionRedirect("ion_settings_space_edit.php?space_code=" . $space["CODE"])
        )
    ));
}

$ca_list->AddAdminContextMenu(array(
    array(
        "TEXT" => "Добавить",
        "LINK" => "ion_settings_conf.php",
        "TITLE" => "Добавить",
        "ICON" => "btn_new",
    ),
));

$ca_list->CheckListMode();
?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php"); ?>

<?php
$ca_list->DisplayList();
?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php"); ?>
<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Page\Asset;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;

// Include Bootstrap and jQuery
Asset::getInstance()->addJs('http://code.jquery.com/jquery-2.1.4.min.js');
Asset::getInstance()->addJs('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js');
$APPLICATION->SetAdditionalCSS('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css');

\Bitrix\Main\Loader::IncludeModule("iblock");

$context = Application::getInstance()->getContext();
$request = $context->getRequest();

$user_name = $request->get("user_name");
$message = $request->get("message");
$submit = $request->get("submit");
$highloadID = $arParams['HIGHLOAD_BLOCK_ID'];


if ($USER->IsAuthorized()) {
    $un = $USER->GetFullName();
} else {
    $un = $user_name;
}

// Element or page type
if (!empty($arParams['OBJECT_COMMENT_TYPE'])) {
    if ($arParams['OBJECT_COMMENT_TYPE'] == 'iblock_id') {
        $elementID = $arParams['OBJECT_COMMENT_STRING'];
    } elseif ($arParams['OBJECT_COMMENT_TYPE'] == 'page') {
        $pageID = $arParams['OBJECT_COMMENT_STRING'];  
    } 
}

if (!empty($submit) && !empty($message) && !empty($un)) {
    $hlblock = HL\HighloadBlockTable::getById($highloadID)->fetch();
    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();

    $arData = array(
        'UF_USER_NAME' => $un,
        'UF_DATE' => ConvertTimeStamp(time(), 'FULL'),
        'UF_TEXT' => $message,
        'UF_ELEMENT_ID' => $elementID,
        'UF_PAGE_ID' => $pageID
    );

    if ($resAdd = $entity_data_class::add($arData)) {
        $mess = 'Спасибо! Ваше сообщение отправлено.';
        BXClearCache(true, "/".SITE_ID.$this->GetRelativePath());
    }

    $comData = $entity_data_class::getList(array(
        "select" => array("*"),
        "order" => array("ID" => "DESC"),
        "filter" => array(
            'UF_ELEMENT_ID' => $elementID,
            'UF_PAGE_ID' => $pageID
        )
    ));
    $arComData = $comData->Fetch();

    $APPLICATION->RestartBuffer();
    $resData = array(
        'user_name' => $arComData['UF_USER_NAME'],
        'user_text' => $arComData['UF_TEXT'],
        'good_message' => $mess,
        'bad_message' => $arResult['ERROR'],
        'user_name' => $un,
        'date' => FormatDate('d F Y H:i:s', MakeTimeStamp($arComData['UF_DATE']->toString())),
        'inputs' => $_POST['inputs'],
        'comment' => $arComData
    );
    echo json_encode($resData);
    exit();
}
if ($this->StartResultCache(3600, $pageID.$elementID.$USER->GetGroups(), "/".SITE_ID.$this->GetRelativePath())) {
    $hlblock = HL\HighloadBlockTable::getById($highloadID)->fetch();
    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();
    $comData = $entity_data_class::getList(array(
        "select" => array("*"),
        "order" => array("ID" => "DESC"),
        "filter" => array(
            'UF_ELEMENT_ID' => $elementID,
            'UF_PAGE_ID' => $pageID
        )
    ));
    while ($arComData = $comData->Fetch()) {
        $arResult['COMMENTS_ITEMS'][] = $arComData;
    }

    $this->includeComponentTemplate();
}

?>
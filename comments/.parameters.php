<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
CModule::IncludeModule("iblock");

$obj_comm_type = array(
    'iblock_id' => 'Элемент инфоблока',
    'page' => 'Страница'
);

$arComponentParameters = array(
    'GROUPS' => array(
    ),
    'PARAMETERS' => array(
        'HIGHLOAD_BLOCK_ID' => array(
            'PARENT' => 'BASE',
            'NAME' => 'ID хайлоадблока',
            'TYPE' => 'STRING'
        ),
        'OBJECT_COMMENT_TYPE' => array(
            'PARENT' => 'BASE',
            'NAME' => 'Тип объекта комментирования',
            'TYPE' => 'LIST',
            'VALUES' => $obj_comm_type
        ),
        'OBJECT_COMMENT_STRING' => array(
            'PARENT' => 'BASE',
            'NAME' => 'Объект комментирования',
            'TYPE' => 'STRING'
        ),
        'CACHE_TIME' => array(
            'PARENT' => 'BASE',
            'NAME' => 'Время кэширования',
            'TYPE' => 'STRING',
            'DEFAULT' => 3600
        ),
    )
);
?>
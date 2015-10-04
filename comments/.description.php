<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
    'NAME' => 'Одноуровневые комментарии',
    'DESCRIPTION' => 'Одноуровневые комментарии на основе Highload блоков',
    'ICON' => '',
    'PATH' => array(
        'ID' => 'communication',
        'CHILD' => array(
            'ID' => 'comments',
            'NAME' => 'Комментарии'
        )
    ),
    'CACHE_PATH' => 'Y'
);
?>
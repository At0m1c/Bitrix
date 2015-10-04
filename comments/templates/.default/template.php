<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @global CUser $USER */
?>
<div class="text-block"></div>
<form action="" method="post" id="comment-form">
    <?if (!$USER->IsAuthorized()):?>
        <div class="form-group">
            <label for="exampleInputEmail1">Имя пользователя</label>
            <input type="text" class="form-control name ajax-input" name="user_name">
        </div>
    <?endif?>
    <div class="form-group">
        <label for="exampleInputPassword1">Текст сообщения</label>
        <textarea class="form-control text ajax-input" rows="3" name="message"></textarea>
    </div>
    <button type="submit" name="submit" value="Отправить" class="btn btn-default comment-send">Отправить</button>
</form>
<div class="comments-list">
    <?foreach ($arResult['COMMENTS_ITEMS'] as $arItem):?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div><?=FormatDate('d F Y H:i:s', MakeTimeStamp($arItem['UF_DATE']->toString()))?> <span class="panel-title"><b><?=$arItem['UF_USER_NAME']?></b></span></div>
            </div>
            <div class="panel-body">
                <p><?=$arItem['UF_TEXT']?></p>
            </div>
        </div>
    <?endforeach?>
</div>
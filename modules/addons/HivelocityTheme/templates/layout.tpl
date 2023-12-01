{include file="{$docroot}/modules/addons/HivelocityTheme/templates/header.tpl"}

{if $smarty.get.page == 'pagemanager'}
    {include file="{$docroot}/modules/addons/HivelocityTheme/templates/pagemanager.tpl"}
{elseif $smarty.get.page == 'addpage'}
    {include file="{$docroot}/modules/addons/HivelocityTheme/templates/addpage.tpl"}
{elseif $smarty.get.page == 'clientarea'}
    {include file="{$docroot}/modules/addons/HivelocityTheme/templates/clientarea.tpl"}
{elseif $smarty.get.page == 'menumanager'}
    {include file="{$docroot}/modules/addons/HivelocityTheme/templates/menumanager.tpl"}
{elseif $smarty.get.page == 'addmenu'}
    {include file="{$docroot}/modules/addons/HivelocityTheme/templates/addmenu.tpl"}
{elseif $smarty.get.page == 'menusetting'}
    {include file="{$docroot}/modules/addons/HivelocityTheme/templates/menusetting.tpl"}
{elseif $smarty.get.page == 'banners'}
    {include file="{$docroot}/modules/addons/HivelocityTheme/templates/banners.tpl"}
{elseif $smarty.get.page == 'addbanner'}
    {include file="{$docroot}/modules/addons/HivelocityTheme/templates/addbanner.tpl"}
{elseif $smarty.get.page == 'customcss'}
    {include file="{$docroot}/modules/addons/HivelocityTheme/templates/customcss.tpl"}
{elseif $smarty.get.page == 'bannersetting'}
    {include file="{$docroot}/modules/addons/HivelocityTheme/templates/bannersetting.tpl"}
{elseif $smarty.get.page == 'footermenu'}
    {include file="{$docroot}/modules/addons/HivelocityTheme/templates/footermenu.tpl"}
{elseif $smarty.get.page == 'addfootermenu'}
    {include file="{$docroot}/modules/addons/HivelocityTheme/templates/addfootermenu.tpl"}
{elseif $smarty.get.page == 'generalsetting'}
    {include file="{$docroot}/modules/addons/HivelocityTheme/templates/generalsetting.tpl"}
{elseif $smarty.get.page == 'footersetting'}
    {include file="{$docroot}/modules/addons/HivelocityTheme/templates/footersetting.tpl"}
{elseif $smarty.get.page == 'colorsetting'}
    {include file="{$docroot}/modules/addons/HivelocityTheme/templates/colorsetting.tpl"}
{/if}

{include file="{$docroot}/modules/addons/HivelocityTheme/templates/footer.tpl"}
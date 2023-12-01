<style type="text/css">

    .dropdowns {
        position: relative;
    }

    .dropdowns .dropdown-toggle {
        display: inline-flex;
        align-items: center;
    }

    .dropdown-toggle {
        user-select: none;
        -webkit-user-select: none;
    }

    .dropdown-toggle {
        white-space: nowrap;
    }

    .dropdown-menu {
        position: absolute;
    }

    .dropdown-menu {
        top: calc(100% + -1rem)!important;
        font-size: .9rem;
    }

    .navbar-nav .dropdown-menu {
        position: static;
        float: none;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        display: none;
        float: left;
        min-width: 10rem;
        padding: 0.5rem 0;
        margin: 0.125rem 0 0;
        font-size: 1rem;
        color: #212529;
        text-align: left;
        list-style: none;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 0.25rem;
    }

    .dropdown-menu .dropdown-item {
        display: flex;
        align-items: center;
    }

    .dropdown-item {
        display: block;
        width: 100%;
        padding: 0.25rem 1.5rem;
        clear: both;
        font-weight: 400;
        color: #212529;
        text-align: inherit;
        white-space: nowrap;
        background-color: transparent;
        border: 0;
        font-size: 15px;
    }

</style>

<div class="" id="contentarea">
    <div style="float:left;width:100%;"> 
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
        <link rel="stylesheet" href="{$domain}/modules/addons/HivelocityTheme/assets/css/layers-ui.css">
        <link rel="stylesheet" href="{$domain}/modules/addons/HivelocityTheme/assets/css/mg_styles.css">
        <div id="layers">
            <div class="lu-app">
                <div class="lu-app-navbar lu-navbar lu-navbar--responsive lu-off-canvas-responsive lu-off-canvas-responsive--right">
                    <div class="lu-navbar__top">
                        <a class="lu-navbar__brand lu-brand lu-brand--product" href="">
                            <div class="lu-brand__logo lu-i-c-6x">
                                <img class="lu-i-c-4x" src="../modules/addons/HivelocityTheme/assets/img/hilogo.png" alt="Hivelocity">
                            </div>
                            <div class="lu-brand__text">
                                Hivelocity Theme 
                            </div>
                        </a>
                    </div>
                    <div class="lu-navbar__nav">
                        <ul class="lu-nav lu-nav--h lu-is-left">

                            <li class="lu-nav__item dropdowns">
                                <a class="dropdown-toggle lu-nav__link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="#">
                                    <i class="lu-nav__link-icon lu-zmdi lu-zmdi-settings"></i>
                                    <span class="lu-nav__link-text">Settings</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item">
                                        <a href="{$systemurl}?module=HivelocityTheme&page=generalsetting" class="dropdown-item">
                                            General Setting
                                        </a>
                                    </li>
                                    <li class="dropdown-item">
                                        <a href="{$systemurl}?module=HivelocityTheme&page=clientarea" class="dropdown-item">
                                            Clientarea Setting
                                        </a>
                                    </li>
                                    <li class="dropdown-item">
                                        <a href="{$systemurl}?module=HivelocityTheme&page=menusetting" class="dropdown-item">
                                            Menu Setting
                                        </a>
                                    </li>
                                    <li class="dropdown-item">
                                        <a href="{$systemurl}?module=HivelocityTheme&page=customcss" class="dropdown-item">
                                            Custom CSS
                                        </a>
                                    </li>
                                    <li class="dropdown-item">
                                        <a href="{$systemurl}?module=HivelocityTheme&page=bannersetting" class="dropdown-item">
                                            Banner Setting
                                        </a>
                                    </li>
                                    <li class="dropdown-item">
                                        <a href="{$systemurl}?module=HivelocityTheme&page=footersetting" class="dropdown-item">
                                            Footer Setting
                                        </a>
                                    </li>
                                    <li class="dropdown-item">
                                        <a href="{$systemurl}?module=HivelocityTheme&page=colorsetting" class="dropdown-item">
                                            Color Setting
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="lu-nav__item {if $smarty.get.page eq 'pagemanager' || $smarty.get.page eq 'addpage'} is-active {/if}">
                                <a class="lu-nav__link" href="{$systemurl}?module=HivelocityTheme&page=pagemanager">
                                <i class="lu-nav__link-icon lu-zmdi lu-zmdi-assignment"></i>
                                <span class="lu-nav__link-text">Page Manager</span>
                            
                                </a>
                            </li>
                            <li class="lu-nav__item {if $smarty.get.page eq 'menumanager' || $smarty.get.page eq 'addmenu' || $smarty.get.page eq 'footermenu' || $smarty.get.page eq 'addfootermenu'} is-active {/if} dropdowns">
                                <a class="dropdown-toggle lu-nav__link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="#">
                                    <i class="lu-nav__link-icon lu-zmdi lu-zmdi-settings"></i>
                                    <span class="lu-nav__link-text">Menu Manager</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item">
                                        <a href="{$systemurl}?module=HivelocityTheme&page=menumanager" class="dropdown-item">
                                            Header Menu
                                        </a>
                                    </li>
                                    <li class="dropdown-item">
                                        <a href="{$systemurl}?module=HivelocityTheme&page=footermenu" class="dropdown-item">
                                            Footer Menu
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="lu-nav__item {if $smarty.get.page eq 'banners' || $smarty.get.page eq 'addbanner'} is-active {/if}">
                                <a class="lu-nav__link" href="{$systemurl}?module=HivelocityTheme&page=banners">
                                <i class="lu-nav__link-icon lu-zmdi lu-zmdi-image"></i>
                                <span class="lu-nav__link-text">Banners</span>
                            
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
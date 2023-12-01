                    </div>

                    {if $sidebarpositon eq 'right'}
                        {if !$inShoppingCart && ($primarySidebar->hasChildren() || $secondarySidebar->hasChildren())}
                            <div class="col-lg-4 col-xl-3">
                                <div class="sidebar">
                                    {include file="$template/includes/sidebar.tpl" sidebar=$primarySidebar}
                                </div>
                                {if !$inShoppingCart && $secondarySidebar->hasChildren()}
                                    <div class="d-none d-lg-block sidebar">
                                        {include file="$template/includes/sidebar.tpl" sidebar=$secondarySidebar}
                                    </div>
                                {/if}
                            </div>
                        {/if}
                    {/if}

                    </div>
                    {if !$inShoppingCart && $secondarySidebar->hasChildren()}
                        <div class="d-lg-none sidebar sidebar-secondary">
                            {include file="$template/includes/sidebar.tpl" sidebar=$secondarySidebar}
                        </div>
                    {/if}
                <div class="clearfix"></div>
            </div>
        </div>
        {if $templatefile == 'homepage'}
        <div class="row" style="background-color: #f0f1f5;padding: 80px 10px;">
            <div class="col-md-12">
                <div class="row client" style="margin-left: 3rem;margin-right: 3rem;">
                    <h2 class="h2">{lang key='bestinclass'}</h2>
                    <p>{lang key='thenetpromoterscore'}</p>
                    <a class="btn contact-us" href="/contact.php">Contact Us</a>
                </div>
            </div>

        </div>
        {/if}
    </section>
    {if $footercss}
        <style>
            {$footercss|html_entity_decode}
        </style>
    {/if}
    <style>
        .contact-us {
            font-weight: bold;
            border: solid 2px #ffbf23;
            transition: all .25s cubic-bezier(0.25, 0.1, 0.25, 1) 0s;
            text-transform: capitalize;
            background-color: #ffbf23;
            color: #fff;
            fill: #fff;
            border-radius: 0;
            padding: 16px 40px;
            width: auto;
        }
        .client{
            width: 100%;
            height: auto;
        }
        .client ul{
            padding: 0;
            margin: 0;
        }
        .client ul li{
            list-style: none;
            display: inline-block;
            width: 250px;
            height: 250px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            justify-content: space-around;
        }
        .client ul li img{
            width: 100%;
            height: 100%;
            padding: 50px;
        }
                .h2
        {
            font-size: 44px;
            font-weight: 700;
        }
        .hoverred:hover
        {
            color: #e31f3d;
        }

        #footer .signup-cta {
            background-color: #fff;
            text-align: center;
            padding: 30px;
            text-align: center;
        }
        #footer .footer-heading {
            font-size: 22px;
            font-weight: 600;
            color: #000;
            margin-bottom: 5px;
        }
        #footer .get-stated {
            font-size: 16px;
            cursor: pointer;
        }
        #footer .get-stated, .get-stated:visited {
            font-weight: bold;
            border: solid 2px #ffbf23;
            transition: all .25s cubic-bezier(0.25, 0.1, 0.25, 1) 0s;
            text-transform: capitalize;
            background-color: #ffbf23;
            color: #fff;
            fill: #fff;
            border-radius: 0;
            padding: 13px 30px;
        }
    </style>
    <footer id="footer" class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                <ul class="nav justify-content-lg-start mb-7" style="display: block;">
                    <div class="row">
                    {foreach $footermenus as $menu} 
                        
                        {if !$menu['child']}
                            {continue}
                        {/if}

                        {if $menu['child']}
                            <div class="col-md-3">
                        {/if}

                        <li class="nav-item text-white" style="margin-bottom: -15px;">
                            <a class="nav-link">
                                {$menu['name']}
                            </a>
                        </li>
                        {foreach $menu['child'] as $childMenu}
                            <li class="nav-item" style="margin-bottom: -15px;">
                                <a class="nav-link" href="{$childMenu['link']}" {if $childMenu['newtab'] eq 1} target="_blank"{/if}>
                                    {$childMenu['name']}
                                </a>
                            </li>
                        {/foreach}

                        {if $menu['child']}
                            </div>
                        {/if}
                        
                    {/foreach}
                    {if $acceptTOS}
                        <li class="nav-item">
                            <a class="nav-link" href="{$tosURL}" target="_blank">{lang key='ordertos'}</a>
                        </li>
                    {/if}
                    </div>
                </ul>
                </div>
                <div class="col-md-4">
                    <div class="signup-cta">
                        <div class="footer-heading">Deploy in minutes.</div>
                        <div style="margin-bottom: 25px;color: #000;">Create a free account to get started.</div>
                        <a class="btn get-stated" href="/clientarea.php">Get Started</a>
                    </div>
                </div>
            </div>
            {if $footercontent}
            <br> <br>   
            <div class="row">
                <div class="col-md-12 justify-content-center text-center">
                    {$footercontent|html_entity_decode}
                </div>
            </div>
            {/if}
            <br> <br>   
            <div class="row">
                <div class="col-md-6">
                    <p class="copyright mb-0" style="margin: 0px 0;">
                        {lang key="copyrightFooterNotice" year=$date_year company=$companyname}
                    </p>
                </div>
                <div class="col-md-6">
                    <ul class="list-inline mb-7 text-center float-lg-right">
                        {include file="$template/includes/social-accounts.tpl"}

                        {if $languagechangeenabled && count($locales) > 1 || $currencies}
                            <li class="list-inline-item">
                                <button type="button" class="btn" data-toggle="modal" data-target="#modalChooseLanguage">
                                    <div class="d-inline-block align-middle">
                                        <div class="iti-flag {if $activeLocale.countryCode === 'GB'}us{else}{$activeLocale.countryCode|lower}{/if}"></div>
                                    </div>
                                    {$activeLocale.localisedName}
                                    /
                                    {$activeCurrency.prefix}
                                    {$activeCurrency.code}
                                </button>
                            </li>
                        {/if}
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <div id="fullpage-overlay" class="w-hidden">
        <div class="outer-wrapper">
            <div class="inner-wrapper">
                <img src="{$WEB_ROOT}/assets/img/overlay-spinner.svg" alt="">
                <br>
                <span class="msg"></span>
            </div>
        </div>
    </div>

    <div class="modal system-modal fade" id="modalAjax" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">{lang key='close'}</span>
                    </button>
                </div>
                <div class="modal-body">
                    {lang key='loading'}
                </div>
                <div class="modal-footer">
                    <div class="float-left loader">
                        <i class="fas fa-circle-notch fa-spin"></i>
                        {lang key='loading'}
                    </div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        {lang key='close'}
                    </button>
                    <button type="button" class="btn btn-primary modal-submit">
                        {lang key='submit'}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <form method="get" action="{$currentpagelinkback}">
        <div class="modal modal-localisation" id="modalChooseLanguage" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        {if $languagechangeenabled && count($locales) > 1}
                            <h5 class="h5 pt-5 pb-3">{lang key='chooselanguage'}</h5>
                            <div class="row item-selector">
                                <input type="hidden" name="language" data-current="{$language}" value="{$language}" />
                                {foreach $locales as $locale}
                                    <div class="col-4">
                                        <a href="#" class="item{if $language == $locale.language} active{/if}" data-value="{$locale.language}">
                                            {$locale.localisedName}
                                        </a>
                                    </div>
                                {/foreach}
                            </div>
                        {/if}
                        {if !$loggedin && $currencies}
                            <p class="h5 pt-5 pb-3">{lang key='choosecurrency'}</p>
                            <div class="row item-selector">
                                <input type="hidden" name="currency" data-current="{$activeCurrency.id}" value="">
                                {foreach $currencies as $selectCurrency}
                                    <div class="col-4">
                                        <a href="#" class="item{if $activeCurrency.id == $selectCurrency.id} active{/if}" data-value="{$selectCurrency.id}">
                                            {$selectCurrency.prefix} {$selectCurrency.code}
                                        </a>
                                    </div>
                                {/foreach}
                            </div>
                        {/if}
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default">{lang key='apply'}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {if !$loggedin && $adminLoggedIn}
        <a href="{$WEB_ROOT}/logout.php?returntoadmin=1" class="btn btn-return-to-admin" data-toggle="tooltip" data-placement="bottom" title="{if $adminMasqueradingAsClient}{lang key='adminmasqueradingasclient'} {lang key='logoutandreturntoadminarea'}{else}{lang key='adminloggedin'} {lang key='returntoadminarea'}{/if}">
            <i class="fas fa-redo-alt"></i>
            <span class="d-none d-md-inline-block">{lang key="admin.returnToAdmin"}</span>
        </a>
    {/if}

    {include file="$template/includes/generate-password.tpl"}

    {$footeroutput}

    <!-- <script>
        $(document).ready(function() {
            if($('p').text()=='Powered by WHMCompleteSolution')
            {
                $(this).hide();
            }
        });
    </script> -->

</body>
</html>

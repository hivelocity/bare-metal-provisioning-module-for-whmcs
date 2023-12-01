<!doctype html>
<html lang="en">
<head>
    <meta charset="{$charset}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{if $kbarticle.title}{$kbarticle.title} - {/if}{$pagetitle} - {$companyname}</title>
    {include file="$template/includes/head.tpl"}
    {$headoutput}
    {if $customcsscode}
        <style>
            {$customcsscode}
        </style>
    {/if}
</head>
<body class="primary-bg-color" style="background-color: #fff;" data-phone-cc-input="{$phoneNumberInputStyle}">

    {$headeroutput}

    <header id="header" class="header">
        {if $loggedin}
            <div class="topbar">
                <div class="container">
                    <div class="d-flex">
                        <div class="mr-auto">
                            <button type="button" class="btn" data-toggle="popover" id="accountNotifications" data-placement="bottom">
                                <i class="far fa-flag"></i>
                                {if count($clientAlerts) > 0}
                                    {count($clientAlerts)}
                                    <span class="d-none d-sm-inline">{lang key='notifications'}</span>
                                {else}
                                    <span class="d-sm-none">0</span>
                                    <span class="d-none d-sm-inline">{lang key='nonotifications'}</span>
                                {/if}
                            </button>
                            <div id="accountNotificationsContent" class="w-hidden">
                                <ul class="client-alerts">
                                {foreach $clientAlerts as $alert}
                                    <li>
                                        <a href="{$alert->getLink()}">
                                            <i class="fas fa-fw fa-{if $alert->getSeverity() == 'danger'}exclamation-circle{elseif $alert->getSeverity() == 'warning'}exclamation-triangle{elseif $alert->getSeverity() == 'info'}info-circle{else}check-circle{/if}"></i>
                                            <div class="message">{$alert->getMessage()}</div>
                                        </a>
                                    </li>
                                {foreachelse}
                                    <li class="none">
                                        {lang key='notificationsnone'}
                                    </li>
                                {/foreach}
                                </ul>
                            </div>
                        </div>

                        <div class="ml-auto">
                            <div class="input-group active-client" role="group">
                                <div class="input-group-prepend d-none d-md-inline">
                                    <span class="input-group-text">{lang key='loggedInAs'}:</span>
                                </div>
                                <div class="btn-group">
                                    <a href="{$WEB_ROOT}/clientarea.php?action=details" class="btn btn-active-client">
                                        <span>
                                            {if $client.companyname}
                                                {$client.companyname}
                                            {else}
                                                {$client.fullName}
                                            {/if}
                                        </span>
                                    </a>
                                    <a href="{routePath('user-accounts')}" class="btn" data-toggle="tooltip" data-placement="bottom" title="Switch Account">
                                        <i class="fad fa-random"></i>
                                    </a>
                                    {if $adminMasqueradingAsClient || $adminLoggedIn}
                                        <a href="{$WEB_ROOT}/logout.php?returntoadmin=1" class="btn btn-return-to-admin" data-toggle="tooltip" data-placement="bottom" title="{if $adminMasqueradingAsClient}{lang key='adminmasqueradingasclient'} {lang key='logoutandreturntoadminarea'}{else}{lang key='adminloggedin'} {lang key='returntoadminarea'}{/if}">
                                            <i class="fas fa-redo-alt"></i>
                                            <span class="d-none d-md-inline-block">{lang key="admin.returnToAdmin"}</span>
                                        </a>
                                    {/if}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {/if}

        <div class="navbar navbar-light">
            <div class="container">
                <a class="navbar-brand mr-3" href="{$WEB_ROOT}/index.php">
                    {if $assetLogoPath}
                        <img src="{$assetLogoPath}" alt="{$companyname}" class="logo-img">
                    {else}
                        {$companyname}
                    {/if}
                </a>

                <form method="post" action="{routePath('knowledgebase-search')}" class="form-inline ml-auto">
                    <div class="input-group search d-none d-xl-flex">
                        <div class="input-group-prepend">
                            <button class="btn btn-default" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <input class="form-control appended-form-control font-weight-light" type="text" name="search" placeholder="{lang key="searchOurKnowledgebase"}...">
                    </div>
                </form>

                <ul class="navbar-nav toolbar">
                    <li class="nav-item ml-3">
                        <a class="btn nav-link cart-btn" href="{$WEB_ROOT}/cart.php?a=view">
                            <i class="far fa-shopping-cart fa-fw"></i>
                            <span id="cartItemCount" class="badge badge-info">{$cartitemcount}</span>
                            <span class="sr-only">{lang key="carttitle"}</span>
                        </a>
                    </li>
                    <li class="nav-item ml-3 d-xl-none">
                        <button class="btn nav-link" type="button" data-toggle="collapse" data-target="#mainNavbar">
                            <span class="fas fa-bars fa-fw"></span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="navbar navbar-expand-xl main-navbar-wrapper">
            <div class="container">
                <div class="collapse navbar-collapse" id="mainNavbar">
                    <form method="post" action="{routePath('knowledgebase-search')}" class="d-xl-none">
                        <div class="input-group search w-100 mb-2">
                            <div class="input-group-prepend">
                                <button class="btn btn-default" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <input class="form-control prepended-form-control" type="text" name="search" placeholder="{lang key="searchOurKnowledgebase"}...">
                        </div>
                    </form>
                    <ul id="nav" class="navbar-nav mr-auto">
                        {if $cusmegamenu eq '1'}
                            {include file="$template/includes/meganavbar.tpl" navbar=$primaryMegaNavbar}
                        {else} 
                            {include file="$template/includes/navbar.tpl" navbar=$primaryNavbar}
                        {/if}
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        {include file="$template/includes/navbar.tpl" navbar=$secondaryNavbar rightDrop=true}
                    </ul>
                </div>
            </div>
        </div>
    </header>

    {include file="$template/includes/network-issues-notifications.tpl"}

    {if $isbreadcrumb eq '1'}
    <nav class="master-breadcrumb" aria-label="breadcrumb">
        <div class="container">
            {include file="$template/includes/breadcrumb.tpl"}
        </div>
    </nav>
    {/if}

    {include file="$template/includes/validateuser.tpl"}
    {include file="$template/includes/verifyemail.tpl"}

    {if $templatefile == 'homepage'}
        {if $registerdomainenabled || $transferdomainenabled}
            {include file="$template/includes/domain-search.tpl"}
        {/if}
    {/if}

    <style>
        /*.carousel-caption h1:after {
            content: "";
            position: absolute;
            display: block;
            width: 80px;
            height: 3px;
            background: #f8f8fb;
            left: 0;
            right: 0;
            bottom: 90;
            margin: auto;
        }*/
        .carousel-caption {
          text-align:{$captionalign};
          position:absolute;
          top:20%;
          left:10;
          right:10;
          /*background: white;
          opacity: 0.6;*/
        }
        .carousel-caption h1{
          font-size: 4.5rem;
          color: white;
        }
        .carousel-item img {  
          object-fit: cover;
          object-position: center;
          overflow: hidden;
          height:{$bannerheight}vh;
        }

        .carousel-item:before {
          content: "";
          background-image:
            linear-gradient(
              to bottom,
              transparent, rgba(0,0,0,0.5)
            );
          display: block;
          position: absolute;
          top: 0;
          width: 100vw;
          height: {$bannerheight}vh;
        }
        .typed-cursor .typed-cursor--blink{
            animation: blinker 1.5s linear infinite;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('.carousel-inner div:first').addClass('active');
        });
    </script>
    
    <section id="hero">
        <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                {foreach from=$banners item=v}

                    {if $v['page'] eq $current_pageuri && $v['page']!=''}
                        <div class="carousel-item">
                          <img src="{$domain}/modules/addons/HivelocityTheme/assets/img/{$v['banner']}" class="d-block w-100" alt="{$v['banner']}">
                          <div class="carousel-caption d-none d-md-block">
                            <h1><span class="typed" data-typed-items="{$v['heading']}">{$v['heading']}</span></h1>
                            {$v['content']|html_entity_decode}
                          </div>
                        </div>
                    {elseif $v['page']=='' && $templatefile=='homepage' || $templatefile=='clientareahome'}
                        <div class="carousel-item">
                          <img src="{$domain}/modules/addons/HivelocityTheme/assets/img/{$v['banner']}" class="d-block w-100" alt="{$v['banner']}">
                          <div class="carousel-caption d-none d-md-block">
                            <h1><span class="typed" data-typed-items="{$v['heading']}">{$v['heading']}</span></h1>
                            {$v['content']|html_entity_decode}
                          </div>
                        </div>
                    {/if}
                    
                {/foreach}
            </div>
        </div>        
    </section>
    {if $applyanimation eq '1'}
    <script src="{assetPath file='typed.umd.js'}"></script> 
    <script src="{assetPath file='main.js'}?v=852"></script>
    <script>
        $(document).ready(function() {
            var carouselEl = $('.carousel');
            var carouselItems = carouselEl.find('.carousel-item');
            var index = [0];
            carouselEl.on('slid.bs.carousel', function (event) {

            if(carouselItems.hasClass('active') && $.inArray(carouselItems.siblings('.active').index(), index)<0)
            {
                const select = (el, all = false) => {
                    el = el.trim()
                    if (all) {
                      return [...document.querySelectorAll(el)]
                    } else {
                      return document.querySelector(el)
                    }
                }

                const typed = select('.active .carousel-caption .typed')
                if (typed) {
                    let typed_strings = typed.getAttribute('data-typed-items')
                    typed_strings = typed_strings.split(' ')
                    new Typed('.active .carousel-caption .typed', {
                      strings: typed_strings,
                      loop: true,
                      typeSpeed: 100,
                      backSpeed: 50,
                      backDelay: 2000
                    });
                }
            }

            if($.inArray(carouselItems.siblings('.active').index(), index)<0) {
                index.push(carouselItems.siblings('.active').index());
            }
              
            });
        });
    </script>
     {/if}   
    <section id="main-body">
        <div class="{if !$skipMainBodyContainer}container{/if}">
            <div class="row">

            {if $sidebarpositon eq 'left'}
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
            <div class="{if !$inShoppingCart && ($primarySidebar->hasChildren() || $secondarySidebar->hasChildren())}col-lg-8 col-xl-9{else}col-12{/if} primary-content">

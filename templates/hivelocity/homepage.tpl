{if !empty($productGroups) || $registerdomainenabled || $transferdomainenabled}
    <h2 class="text-center m-4">{lang key='clientHomePanels.productsAndServices'}</h2>

    <div class="card-columns home" style="display: none;">
        {foreach $productGroups as $productGroup}

            <div class="card mb-3">
                <div class="card-body p-lg-4 p-xl-5 text-center">
                    <h3 class="card-title pricing-card-title">
                        {$productGroup->name}
                    </h3>
                    <p>{$productGroup->tagline}</p>
                    <a href="{$productGroup->getRoutePath()}" class="btn btn-block btn-outline-primary">
                        {lang key='browseProducts'}
                    </a>
                </div>
            </div>

        {/foreach}

        {if $registerdomainenabled}
            <div class="card mb-3">
                <div class="card-body p-lg-4 p-xl-5 text-center">
                    <h3 class="card-title pricing-card-title">
                        {lang key='orderregisterdomain'}
                    </h3>
                    <p>{lang key='secureYourDomain'}</p>
                    <a href="{$WEB_ROOT}/cart.php?a=add&domain=register" class="btn btn-block btn-outline-primary">
                        {lang key='navdomainsearch'}
                    </a>
                </div>
            </div>
        {/if}
        {if $transferdomainenabled}
            <div class="card mb-3">
                <div class="card-body p-lg-4 p-xl-5 text-center">
                    <h3 class="card-title pricing-card-title">
                        {lang key='transferYourDomain'}
                    </h3>
                    <p>{lang key='transferExtend'}</p>
                    <a href="{$WEB_ROOT}/cart.php?a=add&domain=transfer" class="btn btn-block btn-outline-primary">
                        {lang key='transferYourDomain'}
                    </a>
                </div>
            </div>
        {/if}
    </div>
{/if}

{$clientareaproducts}

<div class="row my-5">
    <h2 class="h2 text-center">{lang key='premium'}</h2>
    <h6 class="text-center" style="margin-bottom: 74px;">{lang key='experiencequality'}</h6>
    <div class="row mb-3">
        <div class="col-md-6">
            <h4>{lang key='lowestprice'}</h4>
            <p>{lang key='lowestpricedesc'}</p>
            <h4>{lang key='ranked1'}</h4>
            <p>{lang key='ranked1desc'}</p>
        </div>
        <div class="col-md-6">
            <img decoding="async" loading="lazy" width="450" height="280" src="/templates/hivelocity/img/4d4a0220-1-600x400.webp" class="attachment-medium size-medium wp-image-23850" alt="Hivelocity team member and servers" srcset="/templates/hivelocity/img/4d4a0220-1-600x400.webp 600w, /templates/hivelocity/img/4d4a0220-1.webp 640w" sizes="(max-width: 600px) 100vw, 600px">
        </div>
    </div>
   
    <div class="row mb-3"> 
        <div class="col-md-6">
            <br><br>
            <img decoding="async" loading="lazy" width="450" height="280" src="/templates/hivelocity/img/datacenter-top-600x400.webp" class="attachment-medium size-medium wp-image-23843" alt="servers" srcset="/templates/hivelocity/img/datacenter-top-600x400.webp 600w, /templates/hivelocity/img/datacenter-top-768x512.webp 768w, /templates/hivelocity/img/datacenter-top.webp 800w" sizes="(max-width: 600px) 100vw, 600px">
        </div>
        <div class="col-md-6">
            <br><br>
            <h4>{lang key='twodecades'}</h4>
            <p>{lang key='twodecadesdesc'}</p>
            <h4>{lang key='vpsnetwork'}</h4>
            <p>{lang key='vpsnetworkdesc'}</p>
        </div>
    </div>
</div>

<h2 class="text-center m-4" style="display: none;">{lang key='howCanWeHelp'}</h2>

<div class="row my-5 action-icon-btns" style="display: none;">
    <div class="col-6 col-md-4 col-lg">
        <a href="{routePath('announcement-index')}" class="card-accent-teal">
            <figure class="ico-container">
                <i class="fal fa-bullhorn"></i>
            </figure>
            {lang key='announcementstitle'}
        </a>
    </div>
    <div class="col-6 col-md-4 col-lg">
        <a href="serverstatus.php" class="card-accent-pomegranate">
            <figure class="ico-container">
                <i class="fal fa-server"></i>
            </figure>
            {lang key='networkstatustitle'}
        </a>
    </div>
    <div class="col-6 col-md-4 col-lg">
        <a href="{routePath('knowledgebase-index')}" class="card-accent-sun-flower">
            <figure class="ico-container">
                <i class="fal fa-book"></i>
            </figure>
            {lang key='knowledgebasetitle'}
        </a>
    </div>
    <div class="col-6 col-md-4 offset-md-2 offset-lg-0 col-lg">
        <a href="{routePath('download-index')}" class="card-accent-asbestos">
            <figure class="ico-container">
                <i class="fal fa-download"></i>
            </figure>
            {lang key='downloadstitle'}
        </a>
    </div>
    <div class="col-6 offset-3 offset-md-0 col-md-4 col-lg">
        <a href="submitticket.php" class="card-accent-green">
            <figure class="ico-container">
                <i class="fal fa-life-ring"></i>
            </figure>
            {lang key='homepage.submitTicket'}
        </a>
    </div>
</div>

<h2 class="text-center m-4" style="display: none;">{lang key='homepage.yourAccount'}</h2>

<div class="row my-5 action-icon-btns" style="display: none;">
    <div class="col-6 col-md-4 col-lg">
        <a href="clientarea.php" class="card-accent-midnight-blue">
            <figure class="ico-container">
                <i class="fal fa-home"></i>
            </figure>
            {lang key='homepage.yourAccount'}
        </a>
    </div>
    <div class="col-6 col-md-4 col-lg">
        <a href="clientarea.php?action=services" class="card-accent-midnight-blue">
            <figure class="ico-container">
                <i class="far fa-cubes"></i>
            </figure>
            {lang key='homepage.manageServices'}
        </a>
    </div>
    {if $registerdomainenabled || $transferdomainenabled || $numberOfDomains}
        <div class="col-6 col-md-4 col-lg">
            <a href="clientarea.php?action=domains" class="card-accent-midnight-blue">
                <figure class="ico-container">
                    <i class="fal fa-globe"></i>
                </figure>
                {lang key='homepage.manageDomains'}
            </a>
        </div>
    {/if}
    <div class="col-6 col-md-4 offset-md-2 offset-lg-0 col-lg">
        <a href="supporttickets.php" class="card-accent-midnight-blue">
            <figure class="ico-container">
                <i class="fal fa-comments"></i>
            </figure>
            {lang key='homepage.supportRequests'}
        </a>
    </div>
    <div class="col-6 offset-3 offset-md-0 col-md-4 col-lg">
        <a href="clientarea.php?action=masspay&all=true" class="card-accent-midnight-blue">
            <figure class="ico-container">
                <i class="fal fa-credit-card"></i>
            </figure>
            {lang key='homepage.makeAPayment'}
        </a>
    </div>
</div>

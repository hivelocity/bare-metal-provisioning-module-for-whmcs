<link href="{assetPath file='store.css'}" rel="stylesheet">

<div class="landing-page bg-white weebly">

    <div class="hero">
        <div class="container">
            <div class="logo-container">
                <img src="{$WEB_ROOT}/assets/img/marketconnect/weebly/logo.png">
            </div>
            <h2>{lang key="store.websiteBuilder.headline"}</h2>
            <h3>{lang key="store.websiteBuilder.tagline"}</h3>
        </div>
    </div>

    <nav class="navbar navbar-light bg-light navbar-expand-md p-0">
      <div class="container">
        <span class="navbar-brand"></span>
        <button type="button" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#nav-landing-page" aria-expanded="false">
          <span class="sr-only">{lang key="toggleNav"}</span>
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav-landing-page">
          <ul class="nav navbar-nav">
            <li class="nav-item"><a class="nav-link" href="#" onclick="smoothScroll('#overview');return false">{lang key="store.websiteBuilder.tab.overview"}</a></li>
            <li class="nav-item"><a class="nav-link" href="#" onclick="smoothScroll('#features');return false">{lang key="store.websiteBuilder.tab.features"}</a></li>
            <li class="nav-item"><a class="nav-link" href="#" onclick="smoothScroll('#pricing');return false">{lang key="store.websiteBuilder.tab.pricing"}</a></li>
            <li class="nav-item"><a class="nav-link" href="#" onclick="smoothScroll('#faq');return false">{lang key="store.websiteBuilder.tab.faq"}</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="content-block image-standout" id="overview">
        <div class="container">
            <p class="lead text-center">{lang key="store.websiteBuilder.introduction"}</p>
            <br><br>
            <div class="row">
                <div class="col-sm-5">
                    <img src="{$WEB_ROOT}/assets/img/marketconnect/weebly/dragdropeditor.png">
                </div>
                <div class="col-sm-7">
                    <br><br>
                    <h3>{lang key="store.websiteBuilder.ddEditor"}</h3>
                    <p>{lang key="store.websiteBuilder.ddEditorDescription"}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="content-block features" id="features">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="feature">
                    <div class="icon"><img src="{$WEB_ROOT}/assets/img/marketconnect/weebly/icons/builder.png"></div>
                    <h4>{lang key="store.websiteBuilder.features.builder"}</h4>
                    <p>{lang key="store.websiteBuilder.features.builderDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="feature">
                    <div class="icon"><img src="{$WEB_ROOT}/assets/img/marketconnect/weebly/icons/ecommerce.png"></div>
                    <h4>{lang key="store.websiteBuilder.features.ecommerce"}</h4>
                    <p>{lang key="store.websiteBuilder.features.ecommerceDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="feature">
                    <div class="icon"><img src="{$WEB_ROOT}/assets/img/marketconnect/weebly/icons/forms.png"></div>
                    <h4>{lang key="store.websiteBuilder.features.forms"}</h4>
                    <p>{lang key="store.websiteBuilder.features.formsDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="feature">
                    <div class="icon"><img src="{$WEB_ROOT}/assets/img/marketconnect/weebly/icons/templates.png"></div>
                    <h4>{lang key="store.websiteBuilder.features.templates"}</h4>
                    <p>{lang key="store.websiteBuilder.features.templatesDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="feature">
                    <div class="icon"><img src="{$WEB_ROOT}/assets/img/marketconnect/weebly/icons/gallery.png"></div>
                    <h4>{lang key="store.websiteBuilder.features.gallery"}</h4>
                    <p>{lang key="store.websiteBuilder.features.galleryDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="feature">
                    <div class="icon"><img src="{$WEB_ROOT}/assets/img/marketconnect/weebly/icons/blogging.png"></div>
                    <h4>{lang key="store.websiteBuilder.features.blogging"}</h4>
                    <p>{lang key="store.websiteBuilder.features.bloggingDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="feature">
                    <div class="icon"><img src="{$WEB_ROOT}/assets/img/marketconnect/weebly/icons/video.png"></div>
                    <h4>{lang key="store.websiteBuilder.features.video"}</h4>
                    <p>{lang key="store.websiteBuilder.features.videoDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="feature">
                    <div class="icon"><img src="{$WEB_ROOT}/assets/img/marketconnect/weebly/icons/seo.png"></div>
                    <h4>{lang key="store.websiteBuilder.features.seo"}</h4>
                    <p>{lang key="store.websiteBuilder.features.seoDescription"}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-block pricing" id="pricing">
        <div class="container">

            <div class="row">
                <div class="col-md-9">
                    <div class="btn-group" role="group">
                        {foreach $billingCycles as $cycle}
                            <button type="button" class="btn btn-default cycle-change{if $cycle@first} active{/if}" data-cycle="{$cycle}">
                                {lang key={'orderpaymentterm'|cat:$cycle}}
                            </button>
                        {/foreach}
                    </div>
                    <br><br>
                </div>
                {if !$loggedin && $currencies}
                    <div class="col-md-3">
                        <form method="post" action="">
                            <select name="currency" class="form-control currency-selector" onchange="submit()">
                                <option>{lang key="changeCurrency"} ({$activeCurrency.prefix} {$activeCurrency.code})</option>
                                {foreach $currencies as $currency}
                                    <option value="{$currency['id']}">{$currency['prefix']} {$currency['code']}</option>
                                {/foreach}
                            </select>
                        </form>
                    </div>
                {/if}
            </div>

            {if $litePlan}
                <div class="weebly-lite-plan">
                    <div class="pricing float-right">
                        {foreach $litePlan->pricing()->allAvailableCycles() as $pricing}
                            <h4 class="pricing-text {$pricing->cycle()}{if !$pricing@first} w-hidden{/if}">
                                {$pricing->toFullString()}
                            </h4>
                        {foreachelse}
                            {if $inPreview}
                                -
                            {/if}
                        {/foreach}
                        <h4 class="pricing-text not-available w-hidden">-</h4>
                    </div>
                    <h4>{lang key="store.websiteBuilder.pricing.free.headline"}</h4>
                    <h5>{lang key="store.websiteBuilder.pricing.free.tagline"}</h5>
                    <p>{$litePlan->description}</p>
                    <form method="post" action="{routePath('cart-order')}">
                        <input type="hidden" name="pid" value="{$litePlan->id}">
                        <input type="hidden" name="billingcycle" value="">
                        <button type="submit" class="btn btn-default btn-signup">
                            {lang key='getStartedNow'}
                        </button>
                    </form>
                </div>
            {/if}

            <div class="row weebly-plans">
                {if count($products) > 0}
                    {foreach $products as $key => $product}
                        <div class="{if count($products) == 1}col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4{elseif count($products) == 2}col-sm-6{if $key == 0} offset-sm-1{/if}{elseif count($products) == 3}col-md-4{else}col-sm-3{/if}">
                            <div class="pricing-item">
                                <div class="header">
                                    <h4>{$product->name}</h4>
                                    <h5>{lang key="store.websiteBuilder.pricing.idealFor" for=$product->idealFor}</h5>
                                </div>
                                <div class="price">
                                    {foreach $product->pricing()->allAvailableCycles() as $pricing}
                                        <span class="pricing-text {$pricing->cycle()}{if !$pricing@first} w-hidden{/if}">
                                            {$pricing->toFullString()}
                                        </span>
                                    {foreachelse}
                                        {if $inPreview}
                                            -
                                        {/if}
                                    {/foreach}
                                    <span class="pricing-text not-available w-hidden">
                                        -
                                    </span>
                                </div>
                                <div class="feature-heading">{lang key="store.websiteBuilder.pricing.siteFeatures"}</div>
                                <ul class="site-features">
                                    {foreach $product->siteFeatures as $langKey => $feature}
                                        <li>
                                            {lang key="store.websiteBuilder.pricing.features.$langKey"}
                                        </li>
                                    {/foreach}
                                </ul>
                                <div class="feature-heading">{lang key="store.websiteBuilder.pricing.eCommerceFeatures"}</div>
                                <ul class="ecommerce-features">
                                    {foreach $product->ecommerceFeatures as $langKey => $feature}
                                        <li>
                                            {lang key="store.websiteBuilder.pricing.features.$langKey"}
                                        </li>
                                    {/foreach}
                                </ul>
                            </div>
                            <form method="post" action="{routePath('cart-order')}">
                                <input type="hidden" name="pid" value="{$product->id}">
                                <input type="hidden" name="billingcycle" value="">
                                <button type="submit" class="btn btn-primary btn-block btn-signup">{lang key="signup"}</button>
                            </form>
                        </div>
                    {/foreach}
                {elseif $inPreview}
                    <div class="col-12 lead text-center">
                        {lang key="store.websiteBuilder.adminPreview"}
                    </div>
                {/if}
            </div>

        </div>
    </div>

    <div class="content-block faq" id="faq">
        <div class="container">
            <h3 class="text-center">{lang key="store.websiteBuilder.faq.title"}</h3>
            <div class="row">
                {foreach [[1,2,3], [4,5,6], [7,8]] as $columns}
                    <div class="col-md-4">
                        {foreach $columns as $row}
                            <h4>{lang key="store.websiteBuilder.faq.q$row"}</h4>
                            <p>{lang key="store.websiteBuilder.faq.a$row"}</p>
                            {if $row@last && $row != 8}
                                <div class="d-md-none"><hr></div>
                            {else}
                                <hr>
                            {/if}
                        {/foreach}
                    </div>
                {/foreach}
            </div>
        </div>
    </div>

    <div class="content-block trusted-by">
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <img src="{$WEB_ROOT}/assets/img/marketconnect/weebly/logo.png">
                </div>
                <div class="col-sm-7 text-right">
                    {lang key="store.websiteBuilder.trust"}
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    jQuery(document).ready(function(){
        jQuery('.landing-page.weebly .cycle-change').on('click', function() {
            var newCycle = jQuery(this).data('cycle');
            jQuery('.row.weebly-plans .pricing-text').hide();
            jQuery('.landing-page.weebly .' + newCycle).show();
            jQuery('.landing-page.weebly .cycle-change').removeClass('active');
            jQuery(this).addClass('active');
            jQuery('.landing-page.weebly .pricing input[name="billingcycle"]').val(newCycle);
            jQuery('.weebly-plans div.pricing-item').each(function(index) {
                if (jQuery(this).find('.' + newCycle).length <= 0) {
                    jQuery(this).find('span.not-available').show();
                    jQuery(this).parent('div').find('.btn-signup').prop('disabled', true);
                    jQuery(this).fadeTo('slow', 0.5);
                } else {
                    jQuery(this).find('span.not-available').hide();
                    jQuery(this).parent('div').find('.btn-signup').prop('disabled', false);
                    jQuery(this).fadeTo('slow', 1);
                }
            });
        });

        var startCycle = jQuery('.btn.cycle-change.active').data('cycle');
        jQuery('.landing-page.weebly .pricing input[name="billingcycle"]').val(startCycle);
    });
</script>

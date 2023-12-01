<style type="text/css">

    .dropdown-menu .mega-menu {
        padding: 30px 0px 30px;
        width: max-content;
    }

    .dropdown-item:hover, .dropdown-item:focus {
        width: fit-content;
    }

    .mega-menu li span {
        font-size: 14px;
        font-weight: normal;
        opacity: .5;
    }

</style>
{foreach $navbar as $item} 
    
    {if !$item['name'] && is_array($item['child'])}
            {continue}
    {/if}

    <li menuItemName="{$item['name']}" class="d-block{if $item@first} no-collapse{/if}{if $item['isParent']} dropdown no-collapse{/if}">
        <a  class="{if !isset($rightDrop) || !$rightDrop}pr-4{/if}{if $item['isParent']} dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"{else}" href="{$item['link']}"{/if}{if $item['newtab'] eq 1} target="_blank"{/if}>
            {$item['name']}
        </a>
        
        {if $item['child']}
            <ul class="dropdown-menu dropdown-mega" style="left: -100px !important;">
                <li>
                    <div class="mega-menu">
                        <div class="container">
                            <div class="row">
                                {if $item['description']}
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <p>{$item['description']}</p>
                                            </div>
                                        </div>
                                    </div> 
                                {/if}
                                {if !$item['description'] && !$item['customhtml']}
                                <div class="col-md-12">
                                {else}
                                <div class="col-md-6">
                                {/if}
                                    <ul style="padding-left: 0rem;"> 
                                        <div class="row">
                                            {assign var=count value=0}
                                    {foreach $item['child'] as $childItem}

                                        {if $childItem['isParent']}
                                            {assign var=count value=$count+1}
                                            {assign var=col value=12/$count}
                                            <div class="middlechild">
                                            <li class="dropdown-item">
                                                <span class="dropdown-item px-2 py-0"><h5>{$childItem['name']}</h5></span>
                                            </li>
                                        {else}
                                            <li menuItemName="{$childItem['name']}" class="dropdown-item" id="">
                                                <a href="{$childItem['link']}" class="dropdown-item px-2 py-0"{if $childItem['newtab']} target="_blank"{/if}>
                                                    {$childItem['name']}
                                                </a>
                                            </li>
                                        {/if}

                                        {if $childItem['description']}
                                            
                                            <span style="margin-left: 23px;">{$childItem['description']}</span>
                                        {/if}

                                        {if $childItem['customhtml']}
                                            <div style="margin-left: 23px;">
                                                {$childItem['customhtml']}
                                            </div>
                                        {/if}

                                        {if $childItem['child']}
                                            
                                            <ul style="padding-left: 0rem;"> 
                                            {foreach $childItem['child'] as $newChild}

                                                <li menuItemName="{$newChild['name']}" class="dropdown-item" id="">
                                                    <a href="{$newChild['link']}" class="dropdown-item px-2 py-0"{if $newChild['newtab']} target="_blank"{/if}>
                                                        {$newChild['name']}
                                                    </a>
                                                </li>

                                                {if $newChild['description']}
                                            
                                                    <span style="margin-left: 23px;">{$newChild['description']}</span>
                                                {/if}

                                                {if $newChild['customhtml']}
                                                    <div style="margin-left: 23px;">
                                                        {$newChild['customhtml']}
                                                    </div>
                                                {/if}

                                            {/foreach}
                                            </ul>
                                            
                                        {/if}

                                            <!-- <div class="dropdown-divider"></div> -->

                                        {if $childItem['isParent']}
                                            </div>
                                        {/if}

                                    {/foreach}
                                        </div> 
                                    </ul>
                    
                                </div> 
                                {if $item['customhtml']}
                                    <div class="col-md-3">
                                        {$item['customhtml']}
                                    </div>      
                                {/if}                    
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        {/if}
        
    </li>
{/foreach}
{if !isset($rightDrop) || !$rightDrop}
    <li class="d-none dropdown collapsable-dropdown">
        <a class="dropdown-toggle" href="#" id="navbarDropdownMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {lang key='more'}
        </a>
        <ul class="collapsable-dropdown-menu dropdown-menu" aria-labelledby="navbarDropdownMenu">
        </ul>
    </li>
{/if}

<script>
    $(document).ready(function() {
        if($("div").hasClass("middlechild"))
        {
            $(".middlechild").addClass('col-md-{$col}');
        }
    });
</script>
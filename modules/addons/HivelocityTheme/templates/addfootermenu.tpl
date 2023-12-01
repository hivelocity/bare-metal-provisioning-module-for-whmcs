<style>
    input[type="radio"] {
        accent-color: green;
        transform: scale(1.5);
    }
</style>
<div class="lu-app-main">
    <div class="lu-app-main__body">
        <div class="lu-app-main__top lu-top">
            <ul class="lu-breadcrumb lu-type-5">
                <li class="lu-breadcrumb__item is-active">
                <span class="breadcrumb__link">
                    {if empty($footermenu)}Add Footer Menu{else}Edit Footer Menu{/if}
                </span>
                </li>
            </ul>
        </div>

        <div id="" class="vue-app-main-container">
            <div class="lu-row">
                <div class="lu-widget">
                    <div class="lu-widget__body">
                        <div style="padding: 20px;">
                            <div class="form-second-page-configuration">
                                <form method="POST" action="addonmodules.php?module=HivelocityTheme">
                                    <div class="row"> 
                                        <input type="hidden" value="{$footermenu->id}" name="id" class="form-control"> 
                                        <div class="col-sm-6 col-xs-12">
                                            <h6 class="">Name</h6> 
                                            <div class="form-group"> 
                                                <input type="text" value="{$footermenu->name}" required="required" name="name" class="form-control"> 
                                            </div> 
                                        </div>

                                        <div class="col-sm-6 col-xs-12">
                                            <h6 class="">Status</h6> 
                                            <div class="form-group"> 
                                                <select class="form-control" name="status">

                                                    <option value="Active" {if $footermenu->status eq 'Active'}selected{/if}>Active</option>

                                                    <option value="Inactive" {if $footermenu->status eq 'Inactive'}selected{/if}>Inactive</option>

                                                </select>
                                            </div> 
                                        </div>

                                        <div class="col-sm-6 col-xs-12">
                                            <h6 class="">Parent Menu</h6> 
                                            <div class="form-group"> 
                                                <select class="form-control" name="parent">
                                                    <option value="">None</option>
                                                    {foreach from=$footermenus item=v}
                                                        {if $footermenu->id eq $v['id']}
                                                            {continue}
                                                        {/if}
                                                        <option value="{$v['id']}" {if $footermenu->parent eq $v['id']}selected{/if}>{$v['name']}</option>
                                                    {/foreach}
                                                </select>
                                            </div> 
                                        </div>

                                        <div class="col-sm-6 col-xs-12">
                                            <h6 class="">Link</h6> 
                                            <div class="form-group"> 
                                                <input value="{$footermenu->link}" type="text" class="form-control" name="link" id="">
                                            </div> 
                                        </div>

                                        <div class="col-sm-6 col-xs-12">
                                            <h6 class="">Order</h6> 
                                            <div class="form-group"> 
                                                <input value="{$footermenu->order}" type="text" class="form-control" name="order" id="">
                                            </div> 
                                        </div>

                                        <div class="col-sm-6 col-xs-12">
                                            <h6 class="">Display</h6> 
                                            <div class="form-group"> 
                                                <select class="form-control" name="logged_only">

                                                    <option value="Login User" {if $footermenu->logged_only eq 'Login User'}selected{/if}>Login User</option>

                                                    <option value="Guest User" {if $footermenu->logged_only eq 'Guest User'}selected{/if}>Guest User</option>

                                                </select>
                                            </div> 
                                        </div>
                                        
                                        <div class="col-sm-6 col-xs-12">
                                            <h6 class="">Open in new tab?</h6> 
                                            <div class="form-group"> 
                                                <label class="radio-inline">
                                                    <input id="" {if $footermenu->newtab eq 1} checked="checked" {/if} type="radio" name="newtab"  value="1"> Enable
                                                </label>  
                                                <label class="radio-inline">
                                                    <input id="" {if $footermenu->newtab eq 0} checked="checked" {/if} type="radio" name="newtab"  value="0"> Disable
                                                </label>
                                            </div>       
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                        <hr>
                                        {if empty($footermenu)}
                                        
                                            <button type="submit" class="btn btn--success" name="savefootermenu" value="save">Save</button>
                                        {else}
                                            <button type="submit" class="btn btn--success" name="updatefootermenu" value="save">Update</button>
                                        
                                        {/if}
                                            <!-- <button type="submit" class="btn btn--info" name="savepreview" value="preview">Preview</button> -->

                                            <a href="{$systemurl}?module=HivelocityTheme&page=footermenu" class="btn btn--default">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
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
                    {if empty($page)}Add Page{else}Edit Page{/if}
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
                                        <input type="hidden" value="{$page->id}" name="id" class="form-control"> 
                                        <div class="col-sm-6 col-xs-12">
                                            <h6 class="">Name</h6> 
                                            <div class="form-group"> 
                                                <input type="text" value="{$page->name}" required="required" name="name" class="form-control"> 
                                            </div> 
                                        </div>

                                        <div class="col-sm-6 col-xs-12">
                                            <h6 class="">Status</h6> 
                                            <div class="form-group"> 
                                                <select class="form-control" name="status">

                                                    <option value="1" {if $page->publish eq '1'}selected{/if}>Publish</option>

                                                    <option value="0" {if $page->publish eq '0'}selected{/if}>Draft</option>

                                                </select>
                                            </div> 
                                        </div>

                                        <div class="col-sm-6 col-xs-12">
                                            <h6 class="">URL</h6> 
                                            <div class="form-group"> 
                                                <input value="{$page->url}" type="text" class="form-control" name="url" id="">
                                            </div> 
                                        </div>

                                        <div class="col-sm-6 col-xs-12">
                                            <h6 class="">Required Login?</h6> 
                                            <div class="form-group"> 
                                                <label class="radio-inline">
                                                    <input id="" {if $page->required_login eq 1} checked="checked" {/if} type="radio" name="login"  value="1"> Yes
                                                </label>  
                                                <label class="radio-inline">
                                                    <input id="" {if $page->required_login eq 0} checked="checked" {/if} type="radio" name="login"  value="0"> No
                                                </label>
                                            </div>       
                                        </div>

                                        <div class="col-sm-12 col-xs-12">
                                            <h6 class="">Content</h6> 
                                            <div class="form-group"> 
                                                <textarea id="" name="description" class="form-control tinymce">{$page->description}</textarea>  
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                        <hr>
                                        {if empty($page)}
                                        
                                            <button type="submit" class="btn btn--success" name="savepage" value="save">Save</button>
                                        {else}
                                            <button type="submit" class="btn btn--success" name="updatepage" value="save">Update</button>
                                        
                                        {/if}
                                            <!-- <button type="submit" class="btn btn--info" name="savepreview" value="preview">Preview</button> -->

                                            <a href="{$systemurl}?module=HivelocityTheme&page=pagemanager" class="btn btn--default">Cancel</a>
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
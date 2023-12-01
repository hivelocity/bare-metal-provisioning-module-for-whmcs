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
                    {if empty($banner)}Add Banner{else}Edit Banner{/if}
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
                                <form method="POST" action="addonmodules.php?module=HivelocityTheme" enctype="multipart/form-data">
                                    <div class="row"> 
                                        <input type="hidden" value="{$banner->id}" name="id" class="form-control"> 
                                        <div class="col-sm-6 col-xs-12">
                                            <h6 class="">Banner</h6> 
                                            <div class="form-group"> 
                                                <input type="file" {if empty($banner)}required="required"{/if} name="banner" class="form-control"> 
                                            </div> 
                                        </div>
                                        {if $banner->banner}
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group"> 
                                                <center><img src="{$domain}/modules/addons/HivelocityTheme/assets/img/{$banner->banner}" width="200" height="100"></center>
                                            </div> 
                                        </div>
                                        {/if}
                                        <div class="col-sm-6 col-xs-12">
                                            <h6 class="">Heading</h6> 
                                            <div class="form-group"> 
                                                <input value="{$banner->heading}" type="text" class="form-control" name="heading" id="">
                                            </div> 
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <h6 class="">Page</h6> 
                                            <div class="form-group"> 
                                                <select class="form-control" name="page">
                                                    <option value="">None</option>
                                                    {foreach from=$pagearr item=v}
                                                        <option value="{$v['uri']}" {if $banner->page eq $v['uri']}selected{/if}>{$v['name']}</option>
                                                    {/foreach}
                                                </select>
                                            </div> 
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <h6 class="">Content</h6> 
                                            <div class="form-group"> 
                                                <textarea id="" name="content" class="form-control tinymce">{$banner->content}</textarea>  
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                        <hr>
                                        {if empty($banner)}
                                        
                                            <button type="submit" class="btn btn--success" name="savebanner" value="save">Save</button>
                                        {else}
                                            <button type="submit" class="btn btn--success" name="updatebanner" value="save">Update</button>
                                        
                                        {/if}
                                            <!-- <button type="submit" class="btn btn--info" name="savepreview" value="preview">Preview</button> -->

                                            <a href="{$systemurl}?module=HivelocityTheme&page=banners" class="btn btn--default">Cancel</a>
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
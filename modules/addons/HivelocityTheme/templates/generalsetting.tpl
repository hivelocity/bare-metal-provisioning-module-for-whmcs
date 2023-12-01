<style>
    input[type="radio"] {
        accent-color: green;
        transform: scale(1.5);
    }
</style>
<div class="lu-app-main">
    <div class="lu-app-main__body">

        <div id="" class="vue-app-main-container">
            <div class="lu-row">
                <div class="lu-widget">
                    <div class="lu-widget__body">
                        <div style="padding: 20px;">
                            <div class="form-second-page-configuration">
                            <form method="POST" action="">
                            <div class="row">

                                <div class="col-sm-12 col-xs-12"><h2><b>Setting</b> | General </h2> <hr>

                                    <h6 class="">Breadcrumbs</h6> 
                                    <div class="form-group"> 
                                        <label class="radio-inline">
                                            <input id="" {if $settings['isbreadcrumb'] eq 1} checked="checked" {/if} type="radio" name="isbreadcrumb"  value="1"> Enable
                                        </label>  
                                        <label class="radio-inline">
                                            <input id="" {if $settings['isbreadcrumb'] eq 0} checked="checked" {/if} type="radio" name="isbreadcrumb"  value="0"> Disable
                                        </label>
                                    </div>                                    
                                </div> 

                            </div> 
                            <div class="row">
                                <div class="col-sm-12 col-xs-12"><hr>
                                <button type="submit" class="btn btn--success" name="settingsave" value="save">Save</button>
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
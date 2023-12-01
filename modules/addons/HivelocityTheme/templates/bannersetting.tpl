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

                                <div class="col-sm-12 col-xs-12"><h2><b>Setting</b> | Banner </h2> <hr></div> 
                                <div class="col-sm-4 col-xs-4">
                                    <h6 class="">Caption Alignment</h6> 
                                    <div class="form-group"> 
                                        <select class="form-control" name="captionalign">

                                            <option value="center" {if $settings['captionalign'] eq 'center'}selected{/if}>Center</option>
                                            <option value="left" {if $settings['captionalign'] eq 'left'}selected{/if}>Left</option>
                                            <option value="right" {if $settings['captionalign'] eq 'right'}selected{/if}>Right</option>

                                        </select>
                                    </div>                                    
                                </div> 
                                <div class="col-sm-4 col-xs-4">
                                    <h6 class="">Banner Height</h6> 
                                    <div class="form-group"> 
                                        <input type="number" class="form-control" name="bannerheight" value="{$settings['bannerheight']}">
                                    </div>                                    
                                </div> 

                                <div class="col-sm-4 col-xs-4">
                                    <h6 class="">Apply Animation</h6> 
                                    <div class="form-group"> 
                                        <label class="radio-inline">
                                            <input id="" {if $settings['applyanimation'] eq 1} checked="checked" {/if} type="radio" name="applyanimation"  value="1"> Enable
                                        </label>  
                                        <label class="radio-inline">
                                            <input id="" {if $settings['applyanimation'] eq 0} checked="checked" {/if} type="radio" name="applyanimation"  value="0"> Disable
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
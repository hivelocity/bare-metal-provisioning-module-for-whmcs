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

                                <div class="col-sm-12 col-xs-12"><h2><b>Setting</b> | Clientarea </h2> <hr>

                                    <!-- <h6 class="">Sidebar</h6> 
                                    <div class="form-group"> 
                                        <label class="radio-inline">
                                            <input id="sidebarenable" {if $settings['sidebar'] eq 1} checked="checked" {/if} type="radio" name="sidebar"  value="1"> Enable
                                        </label>  
                                        <label class="radio-inline">
                                            <input id="sidebardisable" {if $settings['sidebar'] eq 0} checked="checked" {/if} type="radio" name="sidebar"  value="0"> Disable
                                        </label>
                                    </div> -->

                                    
                                    <span id="sidebarpositon">
                                        <h6 class="">Sidebar Position</h6> 
                                        <div class="form-group"> 
                                            <label class="radio-inline">
                                                <input {if $settings['sidebarpositon'] eq 'left'} checked="checked" {/if} type="radio" name="sidebarpositon"  value="left"> Left
                                            </label>  
                                            <label class="radio-inline">
                                                <input {if $settings['sidebarpositon'] eq 'right'} checked="checked" {/if} type="radio" name="sidebarpositon"  value="right"> Right
                                            </label>
                                        </div>
                                    </span>
                                    
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
<!-- <script>

    $("#sidebarenable").click(function(){
        $("#sidebarpositon").css("display","block");
    });

    $("#sidebardisable").click(function(){
        $("#sidebarpositon").css("display","none");
    });

</script> -->
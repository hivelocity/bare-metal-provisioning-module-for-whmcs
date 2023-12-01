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

                                <div class="col-sm-12 col-xs-12"><h2><b>Setting</b> | Footer </h2> <hr></div> 
                                <div class="col-sm-8 col-xs-8">
                                    <h6 class="">Footer HTML Content</h6> 
                                    <div class="form-group"> 
                                        <textarea id="" name="footercontent" class="form-control tinymce">{$settings['footercontent']}</textarea>  
                                    </div>                                 
                                </div> 

                                <div class="col-sm-8 col-xs-8">
                                    <h6 class="">Footer Custom CSS</h6> 
                                    <div class="form-group"> 
                                        <textarea id="" name="footercss" class="form-control">{$settings['footercss']}</textarea>  
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
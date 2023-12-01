<style>
    input[type="radio"] {
        accent-color: green;
        transform: scale(1.5);
    }
</style>
<link rel="stylesheet" href="{$domain}/modules/addons/HivelocityTheme/assets/css/color-picker.css">
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

                                <div class="col-sm-12 col-xs-12"><h2><b>Setting</b> | Color </h2> <hr></div> 

                                <div class="col-sm-4 col-xs-4">
                                    <h6 class="">Color Picker</h6> 
                                    <a href="#" id="colorpicker" class="btn btn--primary">Color Picker</a>                              
                                </div> 

                                <div class="col-sm-4 col-xs-4">
                                    <h6 class="">Color Code</h6> 
                                    <div class="form-group"> 
                                        <input type="text" id="colorcode" value="{$settings['colorcode']}" name="colorcode" class="form-control"> 
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
<script type="text/javascript" src="{$domain}/modules/addons/HivelocityTheme/assets/js/color-picker.js"></script>    
<script>
    const colorpicker = new Pickr({
          el: '#colorpicker',
          useAsButton: true,

          components: {
            preview: true,
            opacity: true,
            hue: true,

            interaction: {
              hex: true,
              /*rgba: true,
              hsla: true,
              hsva: true,
              cmyk: true,*/
              input: true,
              clear: true,
              save: true
            }
          },

          onChange(hsva) {
            let colorObject = {
              hex: hsva.toHEX().toString(),
              /*rgba: hsva.toRGBA().toString(),
              hsla: hsva.toHSLA().toString(),
              hsva: hsva.toHSVA().toString(),
              cmyk: hsva.toCMYK().toString()*/
            };
            for (let col in colorObject) {
              $('#colorcode').val(colorObject[col]);
            }
          },
        });
</script>
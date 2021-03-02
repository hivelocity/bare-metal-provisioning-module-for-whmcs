$(document).ready(function() {
    
    var emptyFieldLabel = $('select[name = "packageconfigoption[1]"').parent().next();
    var emptyFieldArea  = $('select[name = "packageconfigoption[1]"').parent().next().next();
    var productDropdown = $('select[name = "packageconfigoption[1]"');
    var panel           = $('select[name = "packageconfigoption[1]"').parent().parent().parent();
    
    panel.find("select").width("600px");
    
    emptyFieldLabel.remove();
    emptyFieldArea.remove();
    
    productDropdown.after(' <input id = "createConfigOptionsButton" class="btn btn-primary" type="button" value="Generate Configurable Options"/>');
    
    var createConfigOptionsButton   = $('#createConfigOptionsButton');
    
    createConfigOptionsButton.after(' <img src="images/loading.gif" id="createConfigOptionsLoader" class="" style="display: none;">');
    
    var createConfigOptionsLoader   = $('#createConfigOptionsLoader');
    
    createConfigOptionsLoader.after(' <label id="createConfigOptionsResult" class="" style="display: none;">');
    
    var createConfigOptionsResult   = $('#createConfigOptionsResult');
    
    createConfigOptionsButton.click(function() {
        if(confirm("Are you sure you want to generate configurable options?")) {
            
            createConfigOptionsButton.prop('disabled', true);
            createConfigOptionsLoader.show();
            createConfigOptionsResult.hide();
            
            $.post( window.location.href, { hivelocityProductId: hivelocityProductId, hivelocityRemoteProductId: productDropdown.val(), hivelocityAction: "createConfigOptions" })
            .done(function(data) {
                createConfigOptionsButton.prop('disabled', false);
                createConfigOptionsLoader.hide();
                
                var result = jQuery.parseJSON(data);
                
                if(result.result == "success") {
                    
                    var select = $('select[name="configoptionlinks[]"]');
                    
                    if(result.newGroup) {
                        select.append(result.groupOptionHtml);
                    }
                    
                    createConfigOptionsResult.text('The configurable options have been generated successfully.').show();
                } else if(result.result == "error") {
                    createConfigOptionsResult.text('Error: '+result.message).show();
                }
            });
        }
    });
});

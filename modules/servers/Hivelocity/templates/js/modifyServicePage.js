$(document).ready(function() {
    
    modifyHivelocityCustomField();
});

function modifyHivelocityCustomField() {
    
    $('#servicecontent').unbind('DOMSubtreeModified', modifyHivelocityCustomField);
    
    var button  = $('#showDeviceList');
    
    button.remove();
    
    var customField = $('#customfield'+hivelocityCustomFieldId);
    
    customField.after(' <input id = "showDeviceList" class="btn btn-primary" type="button" value="Show Available Devices"/>')
    customField.addClass("input-400").addClass("input-inline");

    $('#showDeviceList').click(function() {
        customField.replaceWith(hivelocityDeviceSelectHtml);
    });
    
    $('#servicecontent').bind('DOMSubtreeModified', modifyHivelocityCustomField);
}
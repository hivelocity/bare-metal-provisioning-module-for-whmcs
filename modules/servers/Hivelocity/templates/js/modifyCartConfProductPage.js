$(document).ready(function() {
    
    var fieldsIds       = jQuery.parseJSON(hivelocityConfigOptionFieldsIdsJson);
    var customIds = jQuery.parseJSON(hivelocityCustomFieldIdsJson);
    var availability    = jQuery.parseJSON(hivelocityLocationAvailability);
   
    $.each(availability, function(index, value) {
        if(value == "unavailable") {
            $('#'+fieldsIds['Location']+' option[value="'+index+'"]').remove();
        }
    });
    
    var locationCount = $('#'+fieldsIds['Location']).children('option').length;
    if(locationCount == 0) {
        outOfStock();
    }
    
    onOsChange(); 
    onLocChange();
    
    $('#'+fieldsIds['Operating System']).change(function() {
        onOsChange();
    });
    
    $('#'+fieldsIds['Control Panel']).change(function() {
        onCpChange();
    });

    $('#'+fieldsIds['Location']).change(function() {
        onLocChange();
    });

    $('#'+fieldsIds['Managed Services']).change(function() {
        onMsChange();
    });

    if($('#'+fieldsIds['Add user data']).not(":checked") && $('#'+fieldsIds['Customize SSH Key Access']).not(":checked"))
    {
        
        $('.sub-heading').last().hide();
        $('#'+customIds['init']).parent().hide();
        $('#'+customIds['SSH Key Content']).parent().hide();
        $('#'+customIds['Name']).parent().hide();
    }
    else
    {
        $('.sub-heading').last().show();
        $('#'+customIds['init']).parent().show();
        $('#'+customIds['SSH Key Content']).parent().show();
        $('#'+customIds['Name']).parent().show();
    }

    $('#'+fieldsIds['Add user data']).change(function() { 
        
        if($('#'+fieldsIds['Add user data']).is(":checked"))
        {
            $('.sub-heading').last().show();
            $('#'+customIds['init']).parent().show();
        }
        else
        {
            if(!$('#'+fieldsIds['Customize SSH Key Access']).is(":checked"))
            {
                $('.sub-heading').last().hide();
            }
            $('#'+customIds['init']).parent().hide();
        }
    }); 

    $('#'+fieldsIds['Customize SSH Key Access']).change(function() {
        
        if($('#'+fieldsIds['Customize SSH Key Access']).is(":checked"))
        {
            $('.sub-heading').last().show();
            $('#'+customIds['SSH Key Content']).parent().show();
            $('#'+customIds['Name']).parent().show();
        }
        else
        {
            if(!$('#'+fieldsIds['Add user data']).is(":checked"))
            {
                $('.sub-heading').last().hide();
            }
            $('#'+customIds['SSH Key Content']).parent().hide();
            $('#'+customIds['Name']).parent().hide();
        }
    }); 

});

function onOsChange() {
    
    var fieldsIds   = jQuery.parseJSON(hivelocityConfigOptionFieldsIdsJson);
    
    var selectedOs  = $("#" + fieldsIds['Operating System'] + " option:selected" ).text();
    selectedOs      = jQuery.trim(selectedOs);
    
    //Control Panel-------------------------------------------------------------
    
    $('#'+fieldsIds['Control Panel']).prop("disabled", false);
    
    if(~selectedOs.indexOf("CentOS 7.x") || ~selectedOs.indexOf("AlmaLinux 8.x") || ~selectedOs.indexOf("Rocky Linux 8.x") || ~selectedOs.indexOf("Ubuntu 20.x")) {
        
        $('#'+fieldsIds['Control Panel'] + " option:contains(cPanel)").show();
        
    } else {
        
        $('#'+fieldsIds['Control Panel'] + " option:contains(cPanel)").hide();
        
        $('#'+fieldsIds['Control Panel']).prop("disabled", true);
    }
    
    if($("#" + fieldsIds['Control Panel'] + " option:selected").css('display') == "none") {
        
        $('#'+fieldsIds['Control Panel']).val($("#" + fieldsIds['Control Panel'] + " option:first").val());
    }
    
    onCpChange();
    
    //WHMCS-LiteSpeed--------------------------------------------------------------------
    
    $('#'+fieldsIds['WHMCS']).prop("disabled", false);
    $('#'+fieldsIds['LiteSpeed']).prop("disabled", false);
    
    if(~selectedOs.indexOf("CentOS 8.x") || ~selectedOs.indexOf("Windows")) {
        
        $('#'+fieldsIds['WHMCS'] + " option:contains(License)").hide();
        $('#'+fieldsIds['LiteSpeed'] + " option:contains(License)").hide();
        
        $('#'+fieldsIds['WHMCS']).prop("disabled", true);
        $('#'+fieldsIds['LiteSpeed']).prop("disabled", true);
        
    } else {
        
        $('#'+fieldsIds['WHMCS'] + " option:contains(License)").show();
        $('#'+fieldsIds['LiteSpeed'] + " option:contains(License)").show();
    }
    
    if($("#" + fieldsIds['WHMCS'] + " option:selected").css('display') == "none") {
        
        $('#'+fieldsIds['WHMCS']).val($("#" + fieldsIds['WHMCS'] + " option:first").val());
    }
    
    if($("#" + fieldsIds['LiteSpeed'] + " option:selected").css('display') == "none") {
    
        $('#'+fieldsIds['LiteSpeed']).val($("#" + fieldsIds['LiteSpeed'] + " option:first").val());
    }
    
    //Daily Backup & Rapid Restore----------------------------------------------
    
    $('#'+fieldsIds['Daily Backup & Rapid Restore']).prop("disabled", false);
    
    if(~selectedOs.indexOf("CentOS 8.x")) {
        
        $('#'+fieldsIds['Daily Backup & Rapid Restore'] + " option:contains(GB)").hide();
        
        $('#'+fieldsIds['Daily Backup & Rapid Restore']).prop("disabled", true);
    
    } else {
        
        $('#'+fieldsIds['Daily Backup & Rapid Restore'] + " option:contains(GB)").show();
    }
    
    if($("#" + fieldsIds['Daily Backup & Rapid Restore'] + " option:selected").css('display') == "none") {
    
        $('#'+fieldsIds['Daily Backup & Rapid Restore']).val($("#" + fieldsIds['Daily Backup & Rapid Restore'] + " option:first").val());
    }
}

function onCpChange() {
    
    var fieldsIds   = jQuery.parseJSON(hivelocityConfigOptionFieldsIdsJson);
    
    var selectedCp  = $("#" + fieldsIds['Control Panel'] + " option:selected" ).text();
    selectedCp      = jQuery.trim(selectedCp);
    
    //Managed Services----------------------------------------------------------
    
    if(~selectedCp.indexOf("None")) {
        
        $('#'+fieldsIds['Managed Services']).prop("disabled", false);
        
        $('#'+fieldsIds['Managed Services'] + " option:contains(cPanel)").hide();
        
        var selectedOs  = $("#" + fieldsIds['Operating System'] + " option:selected" ).text();
        selectedOs      = jQuery.trim(selectedOs);
        
        if(~selectedOs.indexOf("Windows")) {
            
            $('#'+fieldsIds['Managed Services'] + " option:contains(Linux)").hide();
            $('#'+fieldsIds['Managed Services'] + " option:contains(cPanel)").hide();
            $('#'+fieldsIds['Managed Services'] + " option:contains(Windows)").show();

        } else if(~selectedOs.indexOf("CentOS 8.x")) {
            
            $('#'+fieldsIds['Managed Services'] + " option:contains(Linux)").hide();
            $('#'+fieldsIds['Managed Services'] + " option:contains(cPanel)").hide();
            $('#'+fieldsIds['Managed Services'] + " option:contains(Windows)").hide();
            
            $('#'+fieldsIds['Managed Services']).prop("disabled", true);
            
        } else {
            
            $('#'+fieldsIds['Managed Services'] + " option:contains(Windows)").hide();
            $('#'+fieldsIds['Managed Services'] + " option:contains(Linux)").show();
        }
    
    } else {
        
        $('#'+fieldsIds['Managed Services'] + " option:contains(Windows)").hide();
        $('#'+fieldsIds['Managed Services'] + " option:contains(Linux)").hide();
        $('#'+fieldsIds['Managed Services'] + " option:contains(cPanel)").show();
    }
    
    if($("#" + fieldsIds['Managed Services'] + " option:selected").css('display') == "none") {
        
        $('#'+fieldsIds['Managed Services']).val($("#" + fieldsIds['Managed Services'] + " option:first").val());
    }
    
    onMsChange();
} 

function onLocChange() {
    
    var fieldsIds   = jQuery.parseJSON(hivelocityConfigOptionFieldsIdsJson);
    
    var selectedLoc  = $("#" + fieldsIds['Location'] + " option:selected" ).text();
    selectedLoc      = jQuery.trim(selectedLoc);

    //Load Balancing------------------------------------------------------------
    
    $('#'+fieldsIds['Load Balancing']).prop("disabled", false);
    
    if(~selectedLoc.indexOf("Los Angeles 2") || ~selectedLoc.indexOf("Tampa")  || ~selectedLoc.indexOf("New York City")) {
            
        $('#'+fieldsIds['Load Balancing'] + " option:contains(Load)").show();
        
    } else {
        
        $('#'+fieldsIds['Load Balancing'] + " option:contains(Load)").hide();
        
        $('#'+fieldsIds['Load Balancing']).prop("disabled", true);
    }
    
    if($("#" + fieldsIds['Load Balancing'] + " option:selected").css('display') == "none") {
        
        $('#'+fieldsIds['Load Balancing']).val($("#" + fieldsIds['Load Balancing'] + " option:first").val());
    }
}

function onMsChange() {
    
    var fieldsIds   = jQuery.parseJSON(hivelocityConfigOptionFieldsIdsJson);
    
    var selectedMs  = $("#" + fieldsIds['Managed Services'] + " option:selected" ).text();
    selectedMs     = jQuery.trim(selectedMs);
    
    if(~selectedMs.indexOf("cPanel")) {
            
        $('#'+fieldsIds['Data Migration'] + " option:contains(cPanel to cPanel)").show();
        
    } else {
        
        $('#'+fieldsIds['Data Migration'] + " option:contains(cPanel to cPanel)").hide();
    }
    
    if($("#" + fieldsIds['Data Migration'] + " option:selected").css('display') == "none") {
        
        $('#'+fieldsIds['Data Migration']).val($("#" + fieldsIds['Data Migration'] + " option:first").val());
    }
}

function outOfStock() {
    
    $('#frmConfigureProduct').replaceWith(
        '<div class="alert alert-danger" role="alert" id="containerProductValidationErrors">' +
            '<p>Product Out Of Stock.</p>' +
        '</div>'
    );
}
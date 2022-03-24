$(document).ready(function() {
    
    addGraphPeriodControll();
    addEventAddDomain();
    addEventRemoveDomain();
    addEventAllowIp();
    addEventOpenLoginPage();
    addEventVpnHelp();
    addEventShowIpmiModal();
    addEventShowDnsModal();
});


function addEventAllowIp() {
    $('#allowIpButton').off('click');
    $('#allowIpButton').click(function(event) {
        event.preventDefault();
        hideErrors();
        var button = $(this);
        button.attr('disabled', 'disabled');
        $('#ipmiWait').show();
        $.post({
            type: "POST",
            url: "",
            data: $('#allowIpForm').serialize(),
        }).done(function(dataJson) {
            button.removeAttr("disabled");
            $('#ipmiWait').hide();
            var data = jQuery.parseJSON(dataJson);
            if(data.result == "success") {
                $("#openIpmiPageButton").data("pageIp", data.ipmiPageIp);
                $("#allowIpForm").hide();
                $("#openIpmiPageButton").show();
            } else {
                displayError("IpmiModal",  "The IP address could not be added to the whitelist.");
            }
        });
    });
}

function addEventOpenLoginPage() {
    $('#openIpmiPageButton').off('click');
    $('#openIpmiPageButton').click(function(event) {
        hideErrors();
        var pageAddress = "https://" + $(this).data("pageIp");
        window.open(pageAddress); 
    });
}

function addEventVpnHelp() {
    $('#vpnHelpButton').off('click');
    $('#vpnHelpButton').click(function(event) {
        hideErrors();
        $('#vpnHelpDiv').toggle();
    });
}

function addEventAddDomain() {
    $('#addDomainButton').off('click');
    $('#addDomainButton').click(function(event) {
        event.preventDefault();
        hideErrors();
        var button = $(this);
        button.attr('disabled', 'disabled');
        $.post({
            type: "POST",
            url: "",
            data: $('#addDomainForm').serialize(),
        }).done(function(dataJson) {
            button.removeAttr("disabled");
            var data = jQuery.parseJSON(dataJson);
            if(data.result == "success") {
                var html = ' <tr>' +
                           '    <td style="width:100%; text-align: left">' + data.domainName + '</td>' +
                           '     <td>' +
                           '         <button type="button" class="btn btn-primary" data-toggle="modal" data-domain-id="' + data.hivelocityDomainId + '" data-target="#dnsModal">' +
                           '             DNS&nbsp;Records' +
                           '         </button>' +
                           '     </td>' +
                           '     <td>' +
                           '         <form id="addDomainForm" class="form-inline">' +
                           '             <input type="hidden" name="hivelocityAction"    value="removeDomain">' +
                           '             <input type="hidden" name="hivelocityDomainId"  value="' + data.hivelocityDomainId + '" class="form-control" style="margin-right: 10px">' +
                           '             <button class="removeDomainButton btn btn-danger">Remove</button>' +
                           '         </form>' +
                           '     </td>' +
                           ' </tr>';
                $('#domainListTable').append(html);
                addEventRemoveDomain();
            } else {
                if(data.message != "Action Failed") {
                    displayError("Main", data.message);
                } else {
                    displayError("Main",  "Failed to create domain.");
                }
               
            }
        });
    });
}

function addEventRemoveDomain() {
    $('.removeDomainButton').off('click');
    $('.removeDomainButton').click(function(event) {
        event.preventDefault();
        hideErrors();
        var button  = $(this);
        var form    = $(this).parent();
        button.attr('disabled', 'disabled');
        $.post({
            type: "POST",
            url: "",
            data: form.serialize(),
        }).done(function(dataJson) {
            button.removeAttr("disabled");
            var data = jQuery.parseJSON(dataJson);
            if(data.result == "success") {
                button.closest("tr").remove();
            } else {
                displayError("Main", "Failed to remove domain.");
            }
        });
    });
}

function addEventAddRecord() {
    $('.addRecordButton').off('click');
    $('.addRecordButton').click(function(event) {
        event.preventDefault();
        hideErrors();
        var button  = $(this);
        var form    = button.closest("form");
        button.attr('disabled', 'disabled');
        $.post({
            type: "POST",
            url: "",
            data: form.serialize(),
        }).done(function(dataJson) {
            button.removeAttr("disabled");
            var data = jQuery.parseJSON(dataJson);
            if(data.result == "success") {
                var recordData = data.hivelocityRecordData;
                var html = getRecordRow(recordData);
                $('#dnsRecords' + recordData.type + 'Table').append(html);
                addEventRemoveRecord();
                addEventEditRecord();
            } else {
                if(data.message != "Action Failed") {
                    displayError("DnsModal", data.message);
                } else {
                     displayError("DnsModal", "Failed to create DNS record.");
                }
            }
        });
    });
}

function addEventEditRecord() {
    $('.editRecordButton').off('click');
    $('.editRecordButton').click(function(event) {
        event.preventDefault();
        hideErrors();
        var button  = $(this);
        $('#dnsModalContent').hide();
        $('#dnsModalContentEditRecord').show();
        var recordData = button.data().recordData;
        $('#dnsEditRecordTable').children().remove();
        var html = getRecordEditRow(recordData);
        $('#dnsEditRecordTable').append(html);
        addEventCancelRecord();
        addEventSaveRecord();
    });
    
}

function addEventCancelRecord() {
    $('.cancelRecordButton').off('click');
    $('.cancelRecordButton').click(function(event) {
        event.preventDefault();
        hideErrors();
        $('#dnsModalContent').show();
        $('#dnsModalContentEditRecord').hide();
    });
}

function addEventSaveRecord() {
    $('.saveRecordButton').off('click');
    $('.saveRecordButton').click(function(event) {
        event.preventDefault();
        hideErrors();
        var button      = $(this);
        var form        = button.closest("form");
        var recordId    = form.find('input[name="hivelocityRecordId"]').val();
        button.attr('disabled', 'disabled');
        $.post({
            type: "POST",
            url: "",
            data: form.serialize(),
        }).done(function(dataJson) {
            button.removeAttr("disabled");
            var data = jQuery.parseJSON(dataJson);
            if(data.result == "success") {
                var recordData = data.hivelocityRecordData;
                var html = getRecordRow(recordData);
                $('#dnsRecords' + recordData.type + 'Table').find('#' + recordId).replaceWith(html);
                addEventRemoveRecord();
                addEventEditRecord();
                $('#dnsModalContent').show();
                $('#dnsModalContentEditRecord').hide();
            } else {
                displayError("DnsModal",  "Failed to update DNS record.");
            }
        });
    });
}

function addEventRemoveRecord() {
    $('.removeRecordButton').off('click');
    $('.removeRecordButton').click(function(event) {
        event.preventDefault();
        hideErrors();
        var button  = $(this);
        var form    = $(this).parent();
        button.attr('disabled', 'disabled');
        $.post({
            type: "POST",
            url: "",
            data: form.serialize(),
        }).done(function(dataJson) {
            button.removeAttr("disabled");
            var data = jQuery.parseJSON(dataJson);
            if(data.result == "success") {
                button.closest("tr").remove();
            } else {
                displayError("DnsModal",  "Failed to remove DNS record.");
            }
        });
    });
}

function addEventShowIpmiModal() {
    $('#ipmiModal').on('shown.bs.modal', function (event) {
        hideErrors();
    });
}

function addEventShowDnsModal() {
    
    $('#dnsModal').on('shown.bs.modal', function (event) {
        hideErrors();
        $("#dnsModalLoader").show();
        $("#dnsModalContent").hide();
        $('#dnsModalContentEditRecord').hide();
        var button              = event.relatedTarget;
        var hivelocityDomainId  = button.getAttribute('data-domain-id');
        var postData = {hivelocityAction:"getDnsData", hivelocityDomainId:hivelocityDomainId};
        $.post({
            type: "POST",
            url: "",
            data: postData,
        }).done(function(dataJson) {
            var data = jQuery.parseJSON(dataJson);
            if(data.result == "success") {
// A ---------------------------------------------------------------------------           
                $('#dnsAddRecordATable').children().remove();
                var html =  getRecordAddRow(hivelocityDomainId, 'A');
                $('#dnsAddRecordATable').append(html);
                $('#dnsRecordsATable').children().remove();
                $.each(data["a-record"], function( index, recordData ) {
                    var html = getRecordRow(recordData);
                    $('#dnsRecordsATable').append(html);
                });
// AAAA ------------------------------------------------------------------------          
                $('#dnsAddRecordAAAATable').children().remove();
                var html =  getRecordAddRow(hivelocityDomainId, 'AAAA');
                $('#dnsAddRecordAAAATable').append(html);
                $('#dnsRecordsAAAATable').children().remove();
                $.each(data["aaaa-record"], function( index, recordData ) {
                    var html = getRecordRow(recordData);
                    $('#dnsRecordsAAAATable').append(html);
                });                
// MX ------------------------------------------------------------------------          
                $('#dnsAddRecordMXTable').children().remove();
                var html =  getRecordAddRow(hivelocityDomainId, 'MX');
                $('#dnsAddRecordMXTable').append(html);
                $('#dnsRecordsMXTable').children().remove();
                $.each(data["mx-record"], function( index, recordData ) {
                    var html = getRecordRow(recordData);
                    $('#dnsRecordsMXTable').append(html);
                });    
//------------------------------------------------------------------------------               
                addEventRemoveRecord();
                addEventAddRecord();
                addEventEditRecord()
                $("#dnsModalLoader").hide();
                $("#dnsModalContent").show();
            }
        });
    })
}

function addGraphPeriodControll() {
   
    $('#customPeriodInput').daterangepicker();
   
    $('#periodSelect').change(function() {
       
        var selectedPeriod  = $('#periodSelect').val();
        var customPeriod    = $('#customPeriodInput').val();
        
        if(selectedPeriod == "custom") {
            $("#customPeriodDiv").show();
        } else {
            $("#customPeriodDiv").hide();
            reloadGraph(hivelocityServiceId, selectedPeriod, customPeriod);
        }
    });
    
    $('#customPeriodInput').change(function() {
       
        var selectedPeriod  = $('#periodSelect').val();
        var customPeriod    = $('#customPeriodInput').val();
        
        reloadGraph(hivelocityServiceId, selectedPeriod, customPeriod);
    });
}

function reloadGraph(hivelocityServiceId, selectedPeriod, customPeriod) {
    
    $('#bandwidthGraphImage').hide();
    $('#graphLoader').show();


    var source = "modules/servers/Hivelocity/graph.php"

    $("#bandwidthGraphImage").attr("src", source+"?hivelocityServiceId="+hivelocityServiceId+"&hivelocityPeriod="+selectedPeriod+"&hivelocityCustomPeriod="+customPeriod+"&random="+jQuery.now());

    $("#bandwidthGraphImage").on('load', function() {
        $('#bandwidthGraphImage').show();
        $('#graphLoader').hide();
    });
}

function getRecordRow(recordData) {
    
    var html =  '   <tr id="' + recordData.id + '">';
    if(recordData.type == "A") {
        html += '       <td style="width:37%;   padding-left:10px;  text-align: left">' + recordData.name + '</td>' +
                '       <td style="width:37%;   padding-left:10px;  text-align: left">' + recordData.address + '</td>' +
                '       <td style="width:10%;   padding-left:10px;  text-align: left">' + recordData.ttl + '</td>';
    } else if(recordData.type == "AAAA") {
        html += '       <td style="width:37%;   padding-left:10px;  text-align: left">' + recordData.name + '</td>' +
                '       <td style="width:37%;   padding-left:10px;  text-align: left">' + recordData.address + '</td>' +
                '       <td style="width:10%;   padding-left:10px;  text-align: left">' + recordData.ttl + '</td>';
    } else {
        html += '       <td style="width:32%;   padding-left:10px;  text-align: left">' + recordData.name + '</td>' +
                '       <td style="width:32%;   padding-left:10px;  text-align: left">' + recordData.exchange + '</td>' +
                '       <td style="width:10%;   padding-left:10px;  text-align: left">' + recordData.preference + '</td>' +
                '       <td style="width:10%;   padding-left:10px;  text-align: left">' + recordData.ttl + '</td>';
    }        
    html +=     '       <td></td>' +
                '       <td style="width:1%">' +
                '           <button type="button" class="btn btn-primary editRecordButton"  data-record-data= \'' + JSON.stringify(recordData) + '\'>' +
                '               Edit' +
                '           </button>' +
                '       </td>' +
                '       <td style="width:1%">' +
                '           <form class="form-inline">' +
                '               <input type="hidden" name="hivelocityAction"        value="removeRecord">' +
                '               <input type="hidden" name="hivelocityDomainId"      value="' + recordData.domainId + '">' +
                '               <input type="hidden" name="hivelocityRecordType"    value="' + recordData.type + '">' +
                '               <input type="hidden" name="hivelocityRecordId"      value="' + recordData.id + '">' +
                '               <button class="removeRecordButton btn btn-danger">Remove</button>' +
                '           </form>' +
                '       </td>' +
                '   </tr>';
    return html;
}

function getRecordAddRow(domainId, recordType) {
   
    var head =  '   <th style="padding-left:10px;  text-align: left">Hostname</th>' +
                '   <th style="padding-left:10px;  text-align: left">Address</th>' +
                '   <th style="padding-left:10px;  text-align: left">TTL</th>';
    if(recordType == "MX") {
        head =  '   <th style="padding-left:10px;  text-align: left">Hostname</th>' +
                '   <th style="padding-left:10px;  text-align: left">Exchange</th>' +
                '   <th style="padding-left:10px;  text-align: left">Preference</th>' +
                '   <th style="padding-left:10px;  text-align: left">TTL</th>';
    }    
    var html =  '   <tr>' +
                        head +
                '   </tr>' +
                '   <tr>' +
                '       <form class="form-inline">';
    if(recordType == "A") {
        html += '           <td style="width:37%;   text-align: left">' +
                '               <input type="text"      class="form-control" name="hivelocityRecordName"        value="@"       style="width:100%">' +
                '           </td>' +
                '           <td style="width:37%;   text-align: left">' +
                '               <input type="text"      class="form-control" name="hivelocityRecordAddress"     value=""        style="width:100%">' +
                '           </td>' +
                '           <td style="width:10%;   text-align: left">' +
                '               <input type="text"      class="form-control" name="hivelocityRecordTtl"         value="3600"    style="width:100%">' +
                '           </td>';
    } else if(recordType == "AAAA") {
        html += '           <td style="width:37%; text-align: left">' +
                '               <input type="text"      class="form-control" name="hivelocityRecordName"        value="@"       style="width:100%">' +
                '           </td>' +
                '           <td style="width:37%;   text-align: left">' +
                '               <input type="text"      class="form-control" name="hivelocityRecordAddress"     value=""        style="width:100%">' +
                '           </td>' +
                '           <td style="width:10%;   text-align: left">' +
                '               <input type="text"      class="form-control" name="hivelocityRecordTtl"         value="3600"    style="width:100%">' +
                '           </td>';    
    } else {
        html += '           <td style="width:32%; text-align: left">' +
                '               <input type="text"      class="form-control" name="hivelocityRecordName"        value="@"       style="width:100%">' +
                '           </td>' +
                '           <td style="width:32%;   text-align: left">' +
                '               <input type="text"      class="form-control" name="hivelocityRecordExchange"    value=""        style="width:100%">' +
                '           </td>' +
                '           <td style="width:10%;   text-align: left">' +
                '               <input type="text"      class="form-control" name="hivelocityRecordPreference"  value=""        style="width:100%">' +
                '           </td>' +
                '           <td style="width:10%;   text-align: left">' +
                '               <input type="text"      class="form-control" name="hivelocityRecordTtl"         value="3600"    style="width:100%">' +
                '           </td>';
    }
    html +=     '           <td></td>' +
                '           <td style="width:1%">' +
                '               <input type="hidden"                        name="hivelocityAction"                 value="addRecord">' +
                '               <input type="hidden"                        name="hivelocityRecordType"             value="' + recordType + '">' +
                '               <input type="hidden"                        name="hivelocityDomainId"               value="' + domainId + '">' +
                '               <button type="button" class="btn btn-success addRecordButton">' +
                '                   Add&nbsp;Record' +
                '               </button>' +
                '           </td>' +
                '       </form>' +
                '   </tr>';
    return html;
}

function getRecordEditRow(recordData) {
    
    
    var head =  '   <th style="padding-left:10px;  text-align: left">Hostname</th>' +
                '   <th style="padding-left:10px;  text-align: left">Address</th>' +
                '   <th style="padding-left:10px;  text-align: left">TTL</th>';
    if(recordData.type == "MX") {
        head =  '   <th style="padding-left:10px;  text-align: left">Hostname</th>' +
                '   <th style="padding-left:10px;  text-align: left">Exchange</th>' +
                '   <th style="padding-left:10px;  text-align: left">Preference</th>' +
                '   <th style="padding-left:10px;  text-align: left">TTL</th>';
    }    
    var html =  '   <tr>' +
                        head +
                '   </tr>' +
                '   <tr>' +
                '       <form class="form-inline">';
    if(recordData.type == "A") {
        html += '           <td style="width:37%;   text-align: left">' +
                '               <input type="text"      class="form-control" name="hivelocityRecordName"        value="' + recordData.name + '"         style="width:100%">' +
                '           </td>' +
                '           <td style="width:37%;   text-align: left">' +
                '               <input type="text"      class="form-control" name="hivelocityRecordAddress"     value="' + recordData.address + '"      style="width:100%">' +
                '           </td>' +
                '           <td style="width:10%;   text-align: left">' +
                '               <input type="text"      class="form-control" name="hivelocityRecordTtl"         value="' + recordData.ttl + '"          style="width:100%">' +
                '           </td>';
    } else if(recordData.type == "AAAA") {
        html += '           <td style="width:37%; text-align: left">' +
                '               <input type="text"      class="form-control" name="hivelocityRecordName"        value="' + recordData.name + '"         style="width:100%">' +
                '           </td>' +
                '           <td style="width:37%;   text-align: left">' +
                '               <input type="text"      class="form-control" name="hivelocityRecordAddress"     value="' + recordData.address + '"      style="width:100%">' +
                '           </td>' +
                '           <td style="width:10%;   text-align: left">' +
                '               <input type="text"      class="form-control" name="hivelocityRecordTtl"         value="' + recordData.ttl + '"          style="width:100%">' +
                '           </td>';
    } else {
        html += '           <td style="width:32%; text-align: left">' +
                '               <input type="text"      class="form-control" name="hivelocityRecordName"        value="' + recordData.name + '"         style="width:100%">' +
                '           </td>' +
                '           <td style="width:32%;   text-align: left">' +
                '               <input type="text"      class="form-control" name="hivelocityRecordExchange"    value="' + recordData.exchange + '"     style="width:100%">' +
                '           </td>' +
                '           <td style="width:10%;   text-align: left">' +
                '               <input type="text"      class="form-control" name="hivelocityRecordPreference"  value="' + recordData.preference + '"   style="width:100%">' +
                '           </td>' +
                '           <td style="width:10%;   text-align: left">' +
                '               <input type="text"      class="form-control" name="hivelocityRecordTtl"         value="' + recordData.ttl + '"          style="width:100%">' +
                '           </td>';
    }
    html +=     '           <td></td>' +
                '           <td style="width:1%">' +
                '               <input type="hidden"                        name="hivelocityAction"                 value="editRecord">' +
                '               <input type="hidden"                        name="hivelocityRecordType"             value="' + recordData.type + '">' +
                '               <input type="hidden"                        name="hivelocityDomainId"               value="' + recordData.domainId + '">' +
                '               <input type="hidden"                        name="hivelocityRecordId"               value="' + recordData.id + '">' +
                '               <button type="button" class="btn btn-success saveRecordButton">' +
                '                   Save&nbsp;Record' +
                '               </button>' +
                '           </td>' +
                '           <td style="width:1%">' +
                '               <button type="button" class="btn btn-secondary cancelRecordButton">' +
                '                   Cancel' +
                '               </button>' +
                '           </td>' +
                '       </form>' +
                '   </tr>';
    return html;
}

function displayError(location, message) {
    var errorBox = $("#hivelocity" + location + "ErrorBox");
    errorBox.html(message);
    errorBox.show();
}

function hideErrors() {
    $("#hivelocityMainErrorBox").hide();
    $("#hivelocityIpmiModalErrorBox").hide();
    $("#hivelocityDnsModalErrorBox").hide();
}

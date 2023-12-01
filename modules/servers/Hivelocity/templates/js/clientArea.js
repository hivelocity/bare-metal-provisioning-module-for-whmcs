$(document).ready(function() {

    addEventAddDomain();
    addEventAddVlan();
    addEventAddVlanRoute();
    addEventRemoveVlan();
    addEventRemoveRoutedVlan();
    addEventupdateInterface();
    addEventRemoveAllRouting();
    addEventAddIPRoute();
    addEventRemoveRoutedIp();
    addEventRequestIps();
    addEventRemoveDomain();
    addEventAllowIp();
    addEventPowerStatus();
    addEventOpenLoginPage();
    addEventVpnHelp();
    addEventShowIpmiModal();
    addEventShowDnsModal();

    // Bandwidth graphs
    initializeBandwidthGraphs();
    setBandwidthGraphPeriodControl();
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
        //$('#domainListTable').removeClass('table');
        $.post({
            type: "POST",
            url: "",
            data: $('#addDomainForm').serialize(),
        }).done(function(dataJson) {
            button.removeAttr("disabled");
            var data = jQuery.parseJSON(dataJson);
            if(data.result == "success") {
                $('#tabDns .container .row').first().append('<div class="alert alert-success">Record Added Successfully</div>');
                
                setTimeout(function() {
                    $('#tabDns .container .row .alert').css("display","none");
                }, 10000);

                var html = ' <tr>' +
                           '    <td style="width:100%; text-align: left">' + data.domainName + '</td>' +
                           '     <td>' +
                           '         <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-domain-id="' + data.hivelocityDomainId + '" data-target="#dnsModal">' +
                           '             DNS&nbsp;Records' +
                           '         </button>' +
                           '     </td>' +
                           '     <td>' +
                           '         <form id="addDomainForm" class="form-inline">' +
                           '             <input type="hidden" name="hivelocityAction"    value="removeDomain">' +
                           '             <input type="hidden" name="hivelocityDomainId"  value="' + data.hivelocityDomainId + '" class="form-control" style="margin-right: 10px">' +
                           '             <button class="removeDomainButton btn btn-sm btn-danger">Remove</button>' +
                           '         </form>' +
                           '     </td>' +
                           ' </tr>';
                $('#domainListTable tbody').append(html);
                addEventRemoveDomain();
            } else {

                if(data.message != "Action Failed") {
                    $('#tabDns .container .row').first().append('<div class="alert alert-danger">'+data.message+'</div>');
                    
                    setTimeout(function() {
                        $('#tabDns .container .row .alert').css("display","none");
                    }, 10000);

                } else {
                    $('#tabDns .container .row').first().append('<div class="alert alert-danger">Failed to create domain.</div>');
                
                    setTimeout(function() {
                        $('#tabDns .container .row .alert').css("display","none");
                    }, 10000);

                }
               
            }
        });
    });
}

function addEventAddVlan() {
    $('#addVlanButton').off('click');
    $('#addVlanButton').click(function(event) {
        event.preventDefault();
        hideErrors();
        var button = $(this);
        button.attr('disabled', 'disabled');
        //$('#vlanListTable').removeClass('table');
        $.post({
            type: "POST",
            url: "",
            data: $('#addVlanForm').serialize(),
        }).done(function(dataJson) {
            button.removeAttr("disabled");
            var data = jQuery.parseJSON(dataJson);
            if(data.result == "success") { // response
                $('#tabVlan .container .row').first().append('<div class="alert alert-success">Record Added Successfully</div>');
                
                setTimeout(function() {
                    $('#tabVlan .container .row .alert').css("display","none");
                }, 10000);

                var html = ' <tr>' +
                           '    <td style="text-align: center">#' + data.response.vlanId + '</td>' +
                           '    <td style="text-align: center">VLAN Tag #' + data.response.vlanTag + '</td>' +
                           '    <td style="text-align: center">' + data.response.facilityCode + '</td>' +
                           '    <td style="text-align: center">' + data.response.type + '</td>' +
                           '     <td>' +
                           '         <form id="addVlanForm" class="">' +
                           '             <input type="hidden" name="hivelocityAction"    value="removeVlan">' +
                           '             <input type="hidden" name="vlanid"  value="' + data.response.vlanId + '" class="form-control" style="margin-right: 10px">' +
                           '             <center><button class="removeVlanButton btn btn-sm btn-danger">Remove</button></center>' +
                           '         </form>' +
                           '     </td>' +
                           ' </tr>';
                $('#vlanListTable tbody').append(html);
                addEventRemoveVlan();
            } else {
                if(data.message != "Action Failed") {
                    $('#tabVlan .container .row').first().append('<div class="alert alert-danger">'+data.message+'</div>');
                    
                    setTimeout(function() {
                        $('#tabVlan .container .row .alert').css("display","none");
                    }, 10000);

                } else {
                    $('#tabVlan .container .row').first().append('<div class="alert alert-danger">Failed to create vlan.</div>');
                    
                    setTimeout(function() {
                        $('#tabVlan .container .row .alert').css("display","none");
                    }, 10000);
                }
               
            }
        });
    });
}

function addEventAddVlanRoute() {
    $('#addVlanRoute').off('click');
    $('#addVlanRoute').click(function(event) { 
        event.preventDefault();
        hideErrors();
        var button = $(this);
        button.attr('disabled', 'disabled');
        $.post({
            type: "POST",
            url: "",
            data: $('#addVlanRouteForm').serialize(),
        }).done(function(dataJson) {
            $('#vlanRouteListTable').show();
            button.removeAttr("disabled");
            var data = jQuery.parseJSON(dataJson); 
            if(data.result == "success") { 
                var html = ' <tr>' +
                           '    <td style="text-align: center">' + data.response.vlan + '</td>' +
                           '     <td>' +
                           '         <form id="" class="">' +
                           '             <input type="hidden" name="hivelocityAction"    value="removeVlanrouting">' +
                           '             <input type="hidden" name="vlanid"  value="' + data.response.vlanid + '" class="form-control" style="margin-right: 10px">' +
                           '             <center><button class="removeVlanrouting btn btn-sm btn-danger">Remove</button></center>' +
                           '         </form>' +
                           '     </td>' +
                           ' </tr>';

                $('#successmsg').css("display","block");
                $('#successmsg').text("Request Successfully Submitted.");
                setTimeout(function() {
                    $('#successmsg').css("display","none");
                }, 3000);

                $('#interfacetask').css("display","block");
                $('#interfacetask').text("Account has 1 queued network tasks. Changes to this interface are disabled until the tasks complete. Estimated time: 30 seconds");
                setTimeout(function() {
                    $('#interfacetask').css("display","none");
                }, 10000);

                $('#vlanRouteListTable tbody').append(html);
                $('.routevlanIdselect option[value="'+data.response.vlanid+'"]').remove();
                addEventRemoveRoutedVlan();
            } else { 
                if(data.message != "Action Failed") {
                    displayError("Main", data.message);
                } else {
                    displayError("Main",  "Failed to Route Vlan.");
                }
               
            }
        });
    });
}

function addEventAddIPRoute() {
    $('#addIpRoute').off('click');
    $('#addIpRoute').click(function(event) { 
        event.preventDefault();
        hideErrors();
        var button = $(this);
        button.attr('disabled', 'disabled');
        $.post({
            type: "POST",
            url: "",
            data: $('#addIpRouteForm').serialize(),
        }).done(function(dataJson) {
            $('#ipRouteListTable').show();
            button.removeAttr("disabled");
            var data = jQuery.parseJSON(dataJson); 
            if(data.result == "success") { 
                var html = ' <tr>' +
                           '    <td style="text-align: center">' + data.response.subnet + '</td>' +
                           '     <td>' +
                           '         <form id="" class="">' +
                           '             <input type="hidden" name="hivelocityAction"    value="removeIprouting">' +
                           '             <input type="hidden" name="subnetid"  value="' + data.response.subnetid + '" class="form-control" style="margin-right: 10px">' +
                           '             <center><button class="removeIprouting btn btn-sm btn-danger">Remove</button></center>' +
                           '         </form>' +
                           '     </td>' +
                           ' </tr>';

                $('#successmsg').css("display","block");
                $('#successmsg').text("Request Successfully Submitted.");
                setTimeout(function() {
                    $('#successmsg').css("display","none");
                }, 3000);

                $('#interfacetask').css("display","block");
                $('#interfacetask').text("Account has 1 queued network tasks. Changes to this interface are disabled until the tasks complete. Estimated time: 30 seconds");
                setTimeout(function() {
                    $('#interfacetask').css("display","none");
                }, 10000);

                $('#ipRouteListTable tbody').append(html);
                $('.routeipselect option[value="'+data.response.subnetid+'"]').remove();
                addEventRemoveRoutedIp();
            } else {
                if(data.message != "Action Failed") {
                    displayError("Main", data.message);
                } else {
                    displayError("Main",  "Failed to Route IP.");
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
        if(confirm('Are you sure you want to delete?')){
            var button  = $(this);
            var form    = $(this).parent().parent();
            button.attr('disabled', 'disabled');
            $.post({
                type: "POST",
                url: "",
                data: form.serialize(),
            }).done(function(dataJson) {
                button.removeAttr("disabled");
                var data = jQuery.parseJSON(dataJson);
                if(data.result == "success") {
                    $('#tabDns .container .row').first().append('<div class="alert alert-success">Record Deleted</div>');
                    
                    setTimeout(function() {
                        $('#tabDns .container .row .alert').css("display","none");
                    }, 10000);

                    button.closest("tr").remove();
                } else {
                    $('#tabDns .container .row').first().append('<div class="alert alert-danger">Failed to remove domain.</div>');
                    
                    setTimeout(function() {
                        $('#tabDns .container .row .alert').css("display","none");
                    }, 10000);
                }
            });
        }
    });
}

function addEventRemoveVlan() {
    $('.removeVlanButton').off('click');
    $('.removeVlanButton').click(function(event) {
        event.preventDefault();
        hideErrors();
        if(confirm('Are you sure you want to delete?')){
            var button  = $(this);
            var form    = $(this).parent().parent();
            button.attr('disabled', 'disabled');
            $.post({
                type: "POST",
                url: "",
                data: form.serialize(),
            }).done(function(dataJson) {
                button.removeAttr("disabled");
                var data = jQuery.parseJSON(dataJson);
                if(data.result == "success") {
                    $('#tabVlan .container .row').first().append('<div class="alert alert-success">Record Deleted</div>');
                    
                    setTimeout(function() {
                        $('#tabVlan .container .row .alert').css("display","none");
                    }, 10000);

                    button.closest("tr").remove();
                } else {
                    displayError("Main", "Failed to remove vlan.");
                    $('#tabVlan .container .row').first().append('<div class="alert alert-danger">Failed to remove vlan.</div>');
                    
                    setTimeout(function() {
                        $('#tabVlan .container .row .alert').css("display","none");
                    }, 10000);
                }
            });
        }
    });
}

function addEventRemoveRoutedVlan() {
    $('.removeVlanrouting').off('click');
    $('.removeVlanrouting').click(function(event) {
        event.preventDefault();
        hideErrors();
        var button  = $(this);
        var form    = $(this).parent().parent();
        if(confirm('Are you sure you want to remove the Port from this VLAN?'))
        {                                
            button.attr('disabled', 'disabled');
            $.post({
                type: "POST",
                url: "",
                data: form.serialize(),
            }).done(function(dataJson) {
                button.removeAttr("disabled");
                var data = jQuery.parseJSON(dataJson);
                if(data.result == "success") {

                    $('#successmsg').css("display","block");
                    $('#successmsg').text("Request Successfully Submitted.");
                    setTimeout(function() {
                        $('#successmsg').css("display","none");
                    }, 3000);

                    $('#interfacetask').css("display","block");
                    $('#interfacetask').text("Account has 1 queued network tasks. Changes to this interface are disabled until the tasks complete. Estimated time: 30 seconds");
                    setTimeout(function() {
                        $('#interfacetask').css("display","none");
                    }, 10000);

                    button.closest("tr").remove();
                    var mySelect = $('.routevlanIdselect');
                    var val = data.response.vlanid;
                    var text = data.response.vlan;
                    mySelect.append($('<option></option>').val(val).html(text));
                } else {
                    displayError("Main", "Failed to remove routed vlan.");
                }
            });
        }
    });
}

function addEventRemoveRoutedIp() {
    $('.removeIprouting').off('click');
    $('.removeIprouting').click(function(event) {
        event.preventDefault();
        hideErrors();
        var button  = $(this);
        var form    = $(this).parent().parent();
        if(confirm('Are you sure you want to remove the IP from this Port?'))
        {                                
            button.attr('disabled', 'disabled');
            $.post({
                type: "POST",
                url: "",
                data: form.serialize(),
            }).done(function(dataJson) {
                button.removeAttr("disabled");
                var data = jQuery.parseJSON(dataJson);
                if(data.result == "success") {

                    $('#successmsg').css("display","block");
                    $('#successmsg').text("Request Successfully Submitted.");
                    setTimeout(function() {
                        $('#successmsg').css("display","none");
                    }, 3000);

                    $('#interfacetask').css("display","block");
                    $('#interfacetask').text("Account has 1 queued network tasks. Changes to this interface are disabled until the tasks complete. Estimated time: 30 seconds");
                    setTimeout(function() {
                        $('#interfacetask').css("display","none");
                    },10000);

                    button.closest("tr").remove();
                    var mySelect = $('.routeipselect');
                    var val = data.response.subnetid;
                    var text = data.response.subnet;
                    mySelect.append($('<option></option>').val(val).html(text));
                } else {
                    displayError("Main", "Failed to remove routed IP.");
                }
            });
        }
    });
}

function addEventupdateInterface() {
    $('.updateinterface').off('click');
    $('.updateinterface').click(function(event) {
        event.preventDefault();
        hideErrors();
        
        if(confirm('Are you sure you want to '+action+' bond0?'))
        {          
            var button  = $(this); 
            var action  = button.text();                     
            button.attr('disabled', 'disabled');
            $.post({
                type: "POST",
                url: "",
                data: { hivelocityAction: "updateInterface",actions:action },
            }).done(function(dataJson) { 
                button.removeAttr("disabled");
                var data = jQuery.parseJSON(dataJson);
                if(data.result == "success") {

                    $('#successmsg').css("display","block");
                    $('#successmsg').text("Request Successfully Submitted.");
                    setTimeout(function() {
                        $('#successmsg').css("display","none");
                    }, 3000);

                    $('#interfacetask').css("display","block");
                    $('#interfacetask').text("Account has 1 queued network tasks. Changes to this interface are disabled until the tasks complete. Estimated time: 30 seconds");
                    setTimeout(function() {
                        $('#interfacetask').css("display","none");
                    }, 10000);

                    if(action=="Disable")
                    {
                        button.text("Enable");
                    }
                    else
                    {
                        button.text("Disable");
                    }
                    
                } else {
                    displayError("Main", "Failed to "+action+" interface");
                }
            });
        }
    });
}

function addEventRemoveAllRouting() {
    $('.removeAllrouting').off('click');
    $('.removeAllrouting').click(function(event) {
        event.preventDefault();
        hideErrors();
        
        if(confirm('Are you sure you want to clear all port configurations?This action is irreversible and may result in your device becoming unreachable.'))
        {          
            var button  = $(this); 
            var action  = button.text();                      
            button.attr('disabled', 'disabled');
            $.post({
                type: "POST",
                url: "",
                data: { hivelocityAction: "removeallrouting" },
            }).done(function(dataJson) { 
                button.removeAttr("disabled");
                var data = jQuery.parseJSON(dataJson);
                if(data.result == "success") {

                    $('#successmsg').css("display","block");
                    $('#successmsg').text("Request Successfully Submitted.");
                    setTimeout(function() {
                        $('#successmsg').css("display","none");
                    }, 3000);

                    $('#interfacetask').css("display","block");
                    $('#interfacetask').text("Account has 1 queued network tasks. Changes to this interface are disabled until the tasks complete. Estimated time: 30 seconds");
                    setTimeout(function() {
                        $('#interfacetask').css("display","none");
                    }, 10000);

                    $('#vlanRouteListTable').hide();
                    var mySelect = $('.routevlanIdselect');
                    $.each(data.response, function(key, value) {   
                        mySelect.append(value);
                    });

                } else {
                    displayError("Main", "Failed to remove all routings");
                }
            });
        }
    });
}

function addEventRequestIps() {
    $('#requestIpButton').off('click');
    $('#requestIpButton').click(function(event) { 
        event.preventDefault();
        hideErrors();
        var button = $(this);
        button.attr('disabled', 'disabled');
        $.post({
            type: "POST",
            url: "",
            data: $('#requestIps').serialize(),
        }).done(function(dataJson) {
            button.removeAttr("disabled");
            var data = jQuery.parseJSON(dataJson); 
            if(data.result == "success") { 
                
                $('#successmsg').css("display","block");
                $('#successmsg').text("Request Successfully Submitted.");
                setTimeout(function() {
                    $('#successmsg').css("display","none");
                }, 3000);
                
            } else {
                if(data.message != "Action Failed") {
                    displayError("Main", data.message);
                } else {
                    displayError("Main",  "Failed to Request IP.");
                }
               
            }
        });
    });
}

function addEventPowerStatus() {
    $('.powerstatusbtn').off('click');
    $('.powerstatusbtn').click(function(event) { 
        event.preventDefault();
        hideErrors();
        var button = $(this);
        button.attr('disabled', 'disabled');
        var status = $(this).text();
        $.post({
            type: "POST",
            url: "",
            data: { hivelocityAction:'changePowerstatus',status:status },
        }).done(function(dataJson) {
            button.removeAttr("disabled");
            var data = jQuery.parseJSON(dataJson); 
            if(data.result == "success") { 
                button.text('POWER '+data.response.powerStatus);
                if(data.response.powerStatus=='ON')
                {
                    $('#powerstatus').text('OFF');
                }
                else if(data.response.powerStatus=='OFF')
                {
                    $('#powerstatus').text('ON');
                }
            } else {
                if(data.message != "Action Failed") {
                    displayError("Main", data.message);
                } else {
                    displayError("Main",  "Failed to change power status.");
                }
               
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
        $('#dnsEditRecordTable tbody').append(html);
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
        if(confirm('Are you sure you want to delete?')){
            var button  = $(this);
            var form    = $(this).parent().parent();
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
        }
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
        var postData = {hivelocityAction:"getDnsData", serviceId:"21", hivelocityDomainId:hivelocityDomainId};
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

// PTR ------------------------------------------------------------------------          
                $('#dnsRecordsPTRTable').children().remove();
                $.each(data["ptr"], function( index, recordData ) {
                    var html = getRecordRow(recordData);
                    $('#dnsRecordsPTRTable').append(html);
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

function getRecordRow(recordData) {
    
    var html =  '   <tr id="' + recordData.id + '">';
    if(recordData.type == "MX") {
        html += '       <td style="width:32%;   padding-left:10px;  text-align: left">' + recordData.name + '</td>' +
                '       <td style="width:32%;   padding-left:10px;  text-align: left">' + recordData.exchange + '</td>' +
                '       <td style="width:10%;   padding-left:10px;  text-align: left">' + recordData.preference + '</td>' +
                '       <td style="width:10%;   padding-left:10px;  text-align: left">' + recordData.ttl + '</td>';
    } else if(recordData.type == "AAAA") {
        html += '       <td style="width:37%;   padding-left:10px;  text-align: left">' + recordData.name + '</td>' +
                '       <td style="width:37%;   padding-left:10px;  text-align: left">' + recordData.address + '</td>' +
                '       <td style="width:10%;   padding-left:10px;  text-align: left">' + recordData.ttl + '</td>';
    }else if(recordData.type == "PTR") {
        html += '       <td style="width:37%;   padding-left:10px;  text-align: left">' + recordData.name + '</td>' +
                '       <td style="width:37%;   padding-left:10px;  text-align: left">' + recordData.address + '</td>';
    } else {
        html += '       <td style="width:37%;   padding-left:10px;  text-align: left">' + recordData.name + '</td>' +
                '       <td style="width:37%;   padding-left:10px;  text-align: left">' + recordData["addresses"]["0"] + '</td>' +
                '       <td style="width:10%;   padding-left:10px;  text-align: left">' + recordData.ttl + '</td>';
    }        
    html +=     '       <td></td>' +
                '       <td style="width:1%">' +
                '           <button type="button" class="btn btn-sm btn-primary editRecordButton"  data-record-data= \'' + JSON.stringify(recordData) + '\'>' +
                '               Edit' +
                '           </button>' +
                '       </td>' +
                '       <td style="width:1%">' +
                '           <form class="form-inline">' +
                '               <input type="hidden" name="hivelocityAction"        value="removeRecord">' +
                '               <input type="hidden" name="hivelocityDomainId"      value="' + recordData.domainId + '">' +
                '               <input type="hidden" name="hivelocityRecordType"    value="' + recordData.type + '">' +
                '               <input type="hidden" name="hivelocityRecordId"      value="' + recordData.id + '">' +
                '               <button class="removeRecordButton btn btn-sm btn-danger">Remove</button>' +
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
                '               <button type="button" class="btn btn-sm btn-success addRecordButton">' +
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
                '               <button type="button" class="btn btn-sm btn-success saveRecordButton">' +
                '                   Save&nbsp;Record' +
                '               </button>' +
                '           </td>' +
                '           <td style="width:1%">' +
                '               <button type="button" class="btn btn-sm btn-secondary cancelRecordButton">' +
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

// HTML template used to render single graph
const bandwidthGraphTemplate = function(graphId, image, lastGraph) {
    return `
        <div id="graph-${graphId}" class="container" style="width:auto; margin-bottom: ${lastGraph ? '0px' : '30px'};">
            <img id="bandwidthGraphImage-${graphId}" src="data:image/png;base64,${image}" alt="Graph" style="max-width:100%">
        </div>            
    `;
}

// Parse data and show all graphs
function renderBandwidthGraphs(graphs) {
    if (graphs.length === 0) return;

    graphs.forEach((graph, i) => {
        $('#tabBandwidthGraphs').append(
          bandwidthGraphTemplate(graph.interface, graph.graphImage, i === graphs.length - 1)
      );
  });
}

function setBandwidthGraphPeriodControl() {
   
    $('#customPeriodInput').daterangepicker();
   
    $('#periodSelect').change(function() {
       
        var selectedPeriod  = $('#periodSelect').val();
        var customPeriod    = $('#customPeriodInput').val();
        
        if(selectedPeriod == "custom") {
            $("#customPeriodDiv").show();
        } else {
            $("#customPeriodDiv").hide();
            reloadBandwidthGraphs(hivelocityServiceId, selectedPeriod, customPeriod);
        }
    });
    
    $('#customPeriodInput').change(function() {
       
        var selectedPeriod  = $('#periodSelect').val();
        var customPeriod    = $('#customPeriodInput').val();
        
        reloadBandwidthGraphs(hivelocityServiceId, selectedPeriod, customPeriod);
    });
}

function reloadBandwidthGraphs(hivelocityServiceId, selectedPeriod, customPeriod) {
    
    $('#tabBandwidthGraphs').empty();
    $('#graphLoader').show();

    $.get( "modules/servers/Hivelocity/graph.php?hivelocityServiceId="+hivelocityServiceId+"&hivelocityPeriod=" + selectedPeriod + "&hivelocityCustomPeriod=" + customPeriod + "&random="+jQuery.now(), function(data) {
        const graphs =  $.parseJSON(data);

        $('#graphLoader').hide();
        renderBandwidthGraphs(graphs);
    });
}

// On initial load show all graphs
function initializeBandwidthGraphs() {
    $.get( "modules/servers/Hivelocity/graph.php?hivelocityServiceId=" + hivelocityServiceId + "&hivelocityPeriod=day&random=" + jQuery.now(), function(data) {
        const graphs =  $.parseJSON(data);

        renderBandwidthGraphs(graphs);
    });
}
<div>
    <div class="alert alert-danger text-center" id="hivelocityMainErrorBox" style="display:none"></div>
    <ul class="nav nav-tabs responsive-tabs-sm">
        <li class="active nav-item"><a data-toggle="tab" class="nav-link active" href="#tabDetails">Details</a></li>
        {if !$orderStatus}
            <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tabBandwidth">Bandwidth</a></li>
            <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tabIpmi">IPMI</a></li>
            <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tabDns">DNS</a></li>
        {/if}
    </ul>
    <div class="tab-content" style="border-style: solid; border-color: #ddd; padding:5px; padding-top: 20px; border-width: 1px; border-top-style: none;" >
        <div id="tabDetails" class="tab-pane fade in active">
            <div class="container" style="width:auto">
                {if $orderStatus}
                    <div class="row">
                        <div class="col-sm-5 text-right">
                            <strong>Order Status</strong>
                        </div>
                        <div class="col-sm-7 text-left">
                            {$orderStatus}
                        </div>
                    </div>
                {else}    
                    <div class="row">
                        <div class="col-sm-5 text-right">
                            <strong>Device Status</strong>
                        </div>
                        <div class="col-sm-7 text-left">
                            {$deviceDetails.status}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5 text-right">
                            <strong>Power Status</strong>
                        </div>
                        <div class="col-sm-7 text-left">
                            {$deviceDetails.powerStatus}
                        </div>
                    </div>
                    {if $initialPassword}
                    <div class="row">
                        <div class="col-sm-5 text-right">
                            <strong>Initial Root Password</strong>
                        </div>
                        <div class="col-sm-7 text-left">
                            {$initialPassword}
                        </div>
                    </div>
                    {/if}
                    <div class="row">
                        <div class="col-sm-5 text-right">
                            <strong>IP Addresses</strong>
                        </div>
                        <div class="col-sm-7 text-left">
                            {foreach from=$deviceDetails.ipAddresses item=ipAddress}
                                {$ipAddress}</br>
                            {/foreach}
                        </div>
                    </div>
                {/if}
            </div>
        </div>
        
        {if !$orderStatus}
        
            <div id="tabBandwidth" class="tab-pane fade">
                <div class="container" style="width:auto">
                    <div class="row" style="margin-bottom:5px">
                        <div class="col">
                            <table class="hivelocityFormTable" style="margin: auto;">
                                <tr>
                                    <td style="width: 120px; text-align: right; padding-right: 5px;">
                                        <strong>Period</strong>
                                    </td>    
                                    <td style="width: 200px; text-align: left">
                                        <select id="periodSelect" class="form-control select-inline">
                                            <option value="day">Day</option>
                                            <option value="week">Week</option>
                                            <option value="month">Month</option>
                                            <option value="custom">Custom</option>
                                        </select>
                                    </td>   
                                </tr>
                            </table>
                        </div>    
                    </div>
                        
                    <div id="customPeriodDiv" class="row" style="margin-bottom:5px; display:none;">
                        <div class="col">
                            <table  class="hivelocityFormTable" style="margin: auto;">
                                <tr>
                                    <td style="width: 120px; text-align: right; padding-right: 5px;">
                                        <strong>Custom Period</strong>
                                    </td>    
                                    <td style="width: 200px; text-align: left">
                                        <input id="customPeriodInput" type="text" class="form-control input-inline">
                                    </td>   
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <img src="admin/images/loading.gif" id="graphLoader" class="" style="display: none;">
                <img id="bandwidthGraphImage" src="modules/servers/Hivelocity/graph.php?hivelocityServiceId={$serviceId}" alt="Graph" style="max-width:100%">
            </div>
            <div id="tabIpmi" class="tab-pane fade">
                <div class="container" style="width:auto">
                    <div class="row" style="margin-bottom:5px">
                        <div class="col-sm-8" style="text-align: left">
                            <table  class="hivelocityFormTable" style="margin: auto;">
                                <tr>
                                    <th style="text-align: right; padding-right: 30px">Sensors</th>
                                </tr>
                                {foreach from = $ipmiData.sensors item = sensorData}
                                    {if {$sensorData.reading}}
                                        <tr>
                                            <td style="text-align: right;padding-right: 30px;">
                                                {$sensorData.name}
                                            </td>
                                            <td style="text-align: right; padding-right: 10px;">
                                                {$sensorData.reading}
                                            </td>
                                            <td style="text-align: left;">
                                                {if {$sensorData.units} == "C"}°{/if}{$sensorData.units}
                                            </td>
                                        </tr>
                                    {/if}
                                {/foreach}
                            </table>
                        </div>
                        <div class="col-sm-4" style="text-align: right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ipmiModal">
                                Connect to IPMI
                            </button>
                        </div>    
                    </div>
                </div>
            </div>
            <div id="tabDns" class="tab-pane fade">
                <div class="container" style="width:auto">
                    <div class="row" style="margin-bottom:5px">
                        <div class="col" style="text-align: left">
                            <form id="addDomainForm" class="form-inline">
                                <input type="hidden" name="hivelocityAction"    value="addDomain">
                                <input type="text"   name="hivelocityDomainName" class="form-control" style="margin-right: 10px">
                                <button id="addDomainButton" class="btn btn-success">Add Domain</button>
                            </form>
                        </div>    
                    </div>
                    <div class="row" style="margin-bottom:5px">
                        <div class="col">
                            <table id="domainListTable"  class="hivelocityFormTable" style="width:100%">
                                {foreach from = $domainList item = domainData}
                                    <tr>
                                        <td style="width:100%; text-align: left">{$domainData.name}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-domain-id="{$domainData.domainId}" data-target="#dnsModal">
                                                DNS&nbsp;Records
                                            </button>
                                        </td>
                                        <td>
                                            <form id="addDomainForm" class="form-inline">
                                                <input type="hidden" name="hivelocityAction"    value="removeDomain">
                                                <input type="hidden" name="hivelocityDomainId"  value="{$domainData.domainId}" class="form-control" style="margin-right: 10px">
                                                <button class="removeDomainButton btn btn-danger">Remove</button>
                                            </form>
                                        </td>
                                    </tr>    
                                {/foreach}
                            </table>
                        </div>
                    </div>
                </div>        
            </div>        
        {/if}
    </div>
    
    <div class="modal fade" id="ipmiModal" tabindex="-1" role="dialog" aria-labelledby="ipmiModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ipmiModalLabel">Connect to IPMI</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container" style="width:auto">
                        <div class="row">
                            <div class="col">
                                <div class="alert alert-danger text-center" id="hivelocityIpmiModalErrorBox" style="display:none"></div>
                                <table  class="hivelocityFormTable" style="width:100%">
                                    <tr>
                                        <td style="width:45%">
                                            <button id="vpnHelpButton" class="btn btn-secondary">Use VPN</button>
                                        </td>
                                        <td style="width:10%">
                                            -OR-
                                        </td>
                                        <td style="width:45%">
                                                <form id="allowIpForm" class="form-inline">
                                                    <input type="hidden" name="hivelocityAction"    value="allowIp">
                                                    <input type="text" class="form-control" name="hivelocityIp" value="{$userIp}" style="width:150px; margin-right:4px">
                                                    <button id="allowIpButton" class="btn btn-success">Allow IP</button>
                                                </form>
                                                <button id="openIpmiPageButton" class="btn btn-success" style="display:none">IPMI Login Page</button>
                                        </td>  
                                        <td style="width:1%">
                                            <img src="admin/images/loading.gif" id="ipmiWait" style="display: none">
                                        </td>   
                                    </tr>            
                                </table>
                            </div>
                        </div>
                        <div class="row">        
                            <div class="col">
                                <div id="vpnHelpDiv" style="display:none; text-align: left">
                                    <h6>Using VPN</h6>
                                    <ol>
                                        <li>Navigate to <a href="https://vpn2.hivelocity.net/">VPN 2 (new)</a> or <a href="https://vpn1.hivelocity.net/">VPN 1</a></li>
                                        <li>Enter your myVelocity username and password</li>
                                        <li>Choose Login form the dropdown menu</li>
                                        <li>Click the "Go" button</li><li>Download the OpenVPN connect client for your operating system</li>
                                        <li>Download the user-locked profile</li>
                                        <li>Open this profile with the OpenVPN connect client and connect</li>
                                        <li>At this point, you can access your device's IPMI interface.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>         
                    </div>    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="dnsModal" tabindex="-1" role="dialog" aria-labelledby="dnsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width:1140px; max-width:1140px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dnsModalLabel">DNS Records</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="admin/images/loading.gif" id="dnsModalLoader">
                    <div class="alert alert-danger text-center" id="hivelocityDnsModalErrorBox" style="display:none"></div>
                    <div id="dnsModalContent" style="display: none">
                        <ul class="nav nav-tabs responsive-tabs-sm">
                            <li class="active nav-item"><a data-toggle="tab" class="nav-link active" href="#tabDnsRecordsA">A</a></li>
                            <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tabDnsRecordsAAAA">AAAA</a></li>
                            <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tabDnsRecordsMX">MX</a></li>
                            {*<li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tabDnsRecordsPTR">PTR</a></li>*}
                        </ul>
                        <div class="tab-content" style="border-style: solid; border-color: #ddd; padding:5px; padding-top: 20px; border-width: 1px; border-top-style: none;" >
                            <div id="tabDnsRecordsA" class="tab-pane fade in active">
                                <form>
                                    <table id="dnsAddRecordATable"  class="hivelocityFormTable" style="width:100%">
                                    
                                    </table>
                                </form>
                                <table id="dnsRecordsATable"  class="hivelocityFormTable" style="width:100%">
                                    
                                </table>
                            </div>
                            <div id="tabDnsRecordsAAAA" class="tab-pane fade in">
                                <form>
                                    <table id="dnsAddRecordAAAATable"  class="hivelocityFormTable" style="width:100%">
                                    
                                    </table>
                                </form>
                                <table id="dnsRecordsAAAATable"  class="hivelocityFormTable" style="width:100%">
                                    
                                </table>
                            </div>
                            <div id="tabDnsRecordsMX" class="tab-pane fade in">
                                <form>
                                    <table id="dnsAddRecordMXTable"  class="hivelocityFormTable" style="width:100%">
                                    
                                    </table>
                                </form>
                                <table id="dnsRecordsMXTable"  class="hivelocityFormTable" style="width:100%">
                                    
                                </table>
                            </div>
                            {*
                            <div id="tabDnsRecordsPTR" class="tab-pane fade in">
                                <table id="dnsRecordsPTRTable" style="width:100%">
                                    
                                </table>
                            </div>
                            *}
                        </div>
                    </div>
                    <div <div id="dnsModalContentEditRecord" style="display: none">
                        <form>
                            <table id="dnsEditRecordTable"  class="hivelocityFormTable" style="width:100%">

                            </table>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>    

<style>
    .hivelocityFormTable td {
        padding:1px;
    }
</style>                        
                        
<script>
    var hivelocityServiceId = {$serviceId};
</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />        
<script src="modules/servers/Hivelocity/templates/js/clientArea.js" type="text/javascript"></script>
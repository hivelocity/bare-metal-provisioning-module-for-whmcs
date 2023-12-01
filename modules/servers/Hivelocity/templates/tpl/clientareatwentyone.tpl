{literal}
<style>
    .stat{font-size: 22px !important;}
</style>

{/literal}
<link href="modules/servers/Hivelocity/templates/css/bootstrap.min.css" rel="stylesheet">
    <div class="alert alert-danger text-center" id="hivelocityMainErrorBox" style="display:none"></div>
    <div class="tiles mb-4" style="text-align: left;">
        <div class="row">
            <div class="col-lg-6 col-xl-3 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-white-75">Device Location</div>
                            <div class="text-lg fw-bold">{$dashboarddetails.location}</div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
  <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
  <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
</svg>                    
                    </div>                    
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-white stretched-link" href="clientarea.php?action=services">View Detail</a>
                    <div class="text-white"><svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                </div>
            </div>
                
            </div>
            <div class="col-lg-6 col-xl-3 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-white-75">Next Renew</div>
                            <div class="text-lg fw-bold">{$dashboarddetails.renewdate}</div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign feather-xl text-white-50"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>                       
                    </div>                    
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-white stretched-link" href="clientarea.php?action=quotes">View Detail</a>
                    <div class="text-white"><svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                </div>
            </div>
                
            </div>
            <div class="col-lg-6 col-xl-3 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-white-75">Monitoring</div>
                            <div class="text-lg fw-bold">{$dashboarddetails.monitorsUp} UP</div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar feather-xl text-white-50"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>                        
                    </div>                    
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-white stretched-link" href="clientarea.php?action=quotes">View Detail</a>
                    <div class="text-white"><svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                </div>
            </div>
                
            </div>
            <div class="col-lg-6 col-xl-3 mb-4">
            <div class="card bg-danger text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-white-75">Backups</div>
                            <div class="text-lg fw-bold">0/0 OK</div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-disc" viewBox="0 0 16 16">
  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
  <path d="M10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 4a4 4 0 0 0-4 4 .5.5 0 0 1-1 0 5 5 0 0 1 5-5 .5.5 0 0 1 0 1zm4.5 3.5a.5.5 0 0 1 .5.5 5 5 0 0 1-5 5 .5.5 0 0 1 0-1 4 4 0 0 0 4-4 .5.5 0 0 1 .5-.5z"/>
</svg>                       
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-white stretched-link" href="clientarea.php?action=quotes">View Detail</a>
                    <div class="text-white"><svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                </div>
            </div>
                
            </div>
        </div>
    </div>
    <div class="row mb-4">                            
        <div class="col-xxl-6 col-xl-6 mb-6">
            <div class="card card-header-actions h-100">
                <div class="card-header">
                    <strong>Service Details</strong>
                    
                </div>
                <div class="card-body">
                    {$servicedetails}
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-xl-6 mb-6">
            <div class="card card-header-actions h-100">
                <div class="card-header">
                    <strong>Hardware Details</strong>                  
                </div>
                <div class="card-body">
                    {$hardwaredetails}
                </div>
            </div>
        </div>        
    </div>
   
<div class="card mb-4">
    <div class="card-header border-bottom">
    <ul class="nav nav-tabs" style="margin-bottom: -0.5rem;border-bottom: 0;margin-right: -0.625rem;margin-left: -0.625rem;">
        <li class="active nav-item"><a data-toggle="tab" class="nav-link active" href="#tabDetails">Details</a></li>
        {if !$orderStatus}
            <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tabIpAssignments">IP Assignments</a></li>
            <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tabBandwidth">Bandwidth</a></li>
            <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tabIpmi">IPMI</a></li>
            <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tabDns">DNS</a></li>
            {if $vlantab eq 'true'}
                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tabVlan">VLAN</a></li>
                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tabInterface">Interfaces</a></li>
            {/if}
            <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#eventLog">Event Log</a></li>
        {/if}
    </ul>
    </div>

    <div class="card-body">
    <div class="tab-content">
        <div id="tabDetails" class="tab-pane fade in active show">
            {if !$orderStatus && $initialPassword}
                <div class="alert alert-info" role="alert" style="margin-bottom:20px;">
                    We've set a temporary password for your device. It should be changed immediately. Password will expire {$passwordExpiresInString}.
                </div>
            {/if}
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
                            {$deviceStatus}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5 text-right">
                            <strong>Power Status</strong>
                        </div>
                        <div class="col-sm-7 text-left">
                            {$devicePowerStatus}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5 text-right">
                            <strong>Default ssh user</strong>
                        </div>
                        <div class="col-sm-7 text-left">
                            {$username}
                        </div>
                    </div>
                    {if $initialPassword}
                        <div class="row">
                            <div class="col-sm-5 text-right">
                                <strong>Default password (expires {$passwordExpiresInString}) </strong>
                            </div>
                            <div class="col-sm-7 text-left">
                                {$initialPassword}
                            </div>
                        </div>
                    {/if}
                    <div class="row">
                        <div class="col-sm-5 text-right">
                            <strong>Primary IP Address</strong>
                        </div>
                        <div class="col-sm-7 text-left">
                            {$primaryIp}
                        </div>
                    </div>
                {/if}
            </div>
        </div>
        
        {if !$orderStatus}
            <div id="tabIpAssignments" class="tab-pane fade">
                <div class="container" style="width:auto">
                    {foreach from=$ips key=key item=ipAssignment}
                        <div {if $key neq (count($ips) - 1)} style="margin-bottom:20px" {/if}>
                            <div class="row">
                                <div class="col-sm-5 text-right">
                                    <strong>Assignment</strong>
                                </div>
                                <div class="col-sm-7 text-left">
                                    {$ipAssignment.description}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5 text-right">
                                    <strong>IP Range (CIDR)</strong>
                                </div>
                                <div class="col-sm-7 text-left">
                                    {$ipAssignment.subnet}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5 text-right">
                                    <strong>Netmask</strong>
                                </div>
                                <div class="col-sm-7 text-left">
                                    {$ipAssignment.netmask}
                                </div>
                            </div>

                            {if empty($ipAssignment.usableIps)}
                                </div>
                                {continue}
                            {/if}

                            <div class="row">
                                <div class="col-sm-5 text-right">
                                    <strong>Gateway IP</strong>
                                </div>
                                <div class="col-sm-7 text-left">
                                    {$ipAssignment.usableIps[0]}
                                </div>
                            </div>

                            {foreach from=$ipAssignment.usableIps key=key item=usableIp}
                                {if $key eq 0} {continue} {/if}

                                <div class="row">
                                    <div class="col-sm-5 text-right">
                                        <strong>Usable IP</strong>
                                    </div>
                                    <div class="col-sm-7 text-left">
                                        {$usableIp}
                                    </div>
                                </div>
                            {/foreach}
                        </div>
                    {foreachelse}
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                No Records Found
                            </div>
                        </div>
                    {/foreach}<br>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <a href="#" data-toggle="modal" data-target="#requestIp">Request More IP Addresses</a>
                        </div>
                    </div>
                </div>
            </div>
        
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
                                        <select id="periodSelect" class="form-select form-control select-inline">
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
                <div id="tabBandwidthGraphs">
                </div>  
            </div>
            <div id="tabIpmi" class="tab-pane fade">
                <div class="container" style="width:auto">
                    <span style="float: left;">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ipmiModal">
                            Connect to IPMI
                        </button>
                        <button type="button" class="btn btn-primary btn-sm powerstatusbtn">POWER {if $devicePowerStatus eq 'ON'}OFF{else}ON{/if}</button>
                        <span id="powerstatus" class="badge {if $devicePowerStatus eq 'OFF'}bg-secondary{else}bg-success{/if} text-white rounded-pill">{$devicePowerStatus}</span>
                    </span><br><br>
                    <table class="table table-striped" id="" style="width:100%" border="1">
                        <tr>
                            <th style="width:50%; text-align: center;">IPMI Sensors</th>
                            <th style="width:50%; text-align: center;">Unit</th>
                        </tr> 
                        {foreach from = $ipmisensors item = sensor}
                            <tr>
                                <td style="width:50%; text-align: center;">{$sensor.name}</td>
                                <td style="width:50%; text-align: center;">{$sensor.unit}</td>
                            </tr>    
                        {foreachelse}
                            <tr>
                                <td colspan="2" style="text-align: center;">Records Not Found</td>
                            </tr>  
                        {/foreach}
                    </table>
                </div>
            </div>
            <div id="tabDns" class="tab-pane fade">
                <div class="container" style="width:auto">
                    <div class="row" style="margin-bottom:5px">
                        <div class="col" style="text-align: left">
                            <form id="addDomainForm" class="form-inline">
                                <input type="hidden" name="hivelocityAction"    value="addDomain">
                                <input type="text"   name="hivelocityDomainName" class="form-control" style="margin-right: 10px">
                                <button id="addDomainButton" class="btn btn-sm btn-success">Add Domain</button>
                            </form>
                        </div>    
                    </div><br>
                    <div class="row" style="margin-bottom:5px">
                        <div class="col">
                            <table id="domainListTable" class="table table-striped" style="width:100%">
                                <tr>
                                    <th>Domains</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                {foreach from = $domainList item = domainData}
                                    <tr>
                                        <td style="width:100%; text-align: left">{$domainData.name}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-domain-id="{$domainData.domainId}" data-target="#dnsModal">
                                                DNS&nbsp;Records
                                            </button>
                                        </td>
                                        <td>
                                            <form>
                                                <input type="hidden" name="hivelocityAction"    value="removeDomain">
                                                <input type="hidden" name="hivelocityDomainId"  value="{$domainData.domainId}" class="form-control" style="margin-right: 10px">
                                                <button class="removeDomainButton btn btn-danger btn-sm">Remove</button>
                                            </form>
                                        </td>
                                    </tr>    
                                {/foreach}
                            </table>
                        </div>
                    </div>
                </div>        
            </div>   
            <div id="tabVlan" class="tab-pane fade">
                <div class="container" style="width:auto">
                    <div class="row" style="margin-bottom:5px">
                        <div class="col" style="text-align: left">
                            <form id="addVlanForm" class="form-inline">
                                <input type="hidden" name="hivelocityAction"    value="addVlan">
                                <select name="facilitycode" class="form-select form-control" style="margin-right: 10px">
                                    <option>Select Location</option>
                                    {foreach from = $locations item = loc}
                                        <option value="{$loc.facility}">{$loc.facility} ({$loc.facility_title})</option>
                                    {/foreach}
                                </select>
                                <select name="vlantype" class="form-select form-control" style="margin-right: 10px">
                                    <option>Select Type</option>
                                    <option value="public">Public</option>
                                    <option value="private">Private</option>
                                </select>
                                <button id="addVlanButton" class="btn btn-sm btn-success">Add Vlan</button>
                            </form>
                        </div>    
                    </div><br>
                    <div class="row" style="margin-bottom:5px">
                        <div class="col">
                            <table id="vlanListTable" class="table table-striped" style="width:100%" border="1">
                                <tr>
                                    <th>ID</th>
                                    <th>Tag</th>
                                    <th>Location</th>
                                    <th>Type</th>
                                    <th></th>
                                </tr>
                                {foreach from = $vlanList item = vlan}
                                    <tr>
                                        <td style="text-align: center">#{$vlan.vlanId}</td>
                                        <td style="text-align: center">VLAN Tag #{$vlan.vlanTag}</td>
                                        <td style="text-align: center" title="{$getLocation[$vlan.facilityCode]}">{$vlan.facilityCode}</td>
                                        <td style="text-align: center">{$vlan.type}</td>
                                        <td>
                                            <form id="" class="">
                                                <input type="hidden" name="hivelocityAction"    value="removeVlan">
                                                <input type="hidden" name="vlanid"  value="{$vlan.vlanId}" class="form-control" style="margin-right: 10px">
                                                <center><button class="removeVlanButton btn btn-danger btn-sm">Remove</button></center>
                                            </form>
                                        </td>
                                    </tr>    
                                {/foreach}
                            </table>
                        </div>
                    </div>
                </div>        
            </div>
            <div id="tabInterface" class="tab-pane fade">
                <div class="container" style="width:auto">
                    <div class="row" style="margin-bottom:5px">
                        <div class="col-md-12">
                            <div class="alert alert-info text-center" style="display: none;" id="successmsg"></div>
                            <div class="alert alert-info text-center" style="display: none;" id="interfacetask"></div>
                        </div><br>
                        <div class="col-md-12" style="text-align: left">

                            <div class="row">
                                <div class="col-md-3">
                                    <h6>bond0 (eth0 + eth1)</h6>
                                </div>
                                <div class="col-md-7">
                                    <button class="removeAllrouting btn btn-sm btn-warning">Remove All Routing</button>
                                    <button class="updateinterface btn btn-sm btn-warning">{$enabled}</button>
                                    <button id="addVlanButton" class="btn btn-sm btn-warning">Unbond</button>
                                    <a href="https://developers.hivelocity.net/docs/ports" target="_blank" class="btn-sm btn-default">Help</a>
                                    
                                </div>
                            </div>
                            <br>
                            <ul class="nav nav-tabs responsive-tabs-sm">
                                <li class="active nav-item"><a data-toggle="tab" class="nav-link active" id="routeiptab" href="#routeip">Route IP</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" id="routevlantab" href="#routevlan">Route VLAN</a></li>
                            </ul>

                            <div id="routeip" class="tab-pane fade in active show"><br>
                                <form id="addIpRouteForm" class="form-inline">
                                    <input type="hidden" name="hivelocityAction"    value="addIpRoute">
                                    <select name="routeip" class="routeipselect form-select form-control" style="margin-right: 10px" {$iproutedisable}>
                                        <option>Select IP</option>
                                        <option value="129459">45.158.37.216/29</option>

                                        {foreach from = $ipList item = ip}
                                            {if !$ip.portIds}
                                            <option value="{$ip.ipId}">ip Tag #{$ip.ipTag} {$ip.facilityCode}</option>
                                            {/if}
                                        {/foreach}
                                    </select>
                                    <button id="addIpRoute" class="btn btn-sm btn-success" {$iproutedisable}>Add</button> 
                                </form>
                                <br>
                                <div class="row" style="margin-bottom:5px">
                                    <div class="col">
                                        <table id="ipRouteListTable" class="table table-striped" style="width:100%" border="1">
                                            <tr>
                                                <th style="text-align: center">Route Ips</th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center">45.158.37.216/29</td>
                                                <td>
                                                    <form id="" action="">
                                                        <input type="hidden" name="hivelocityAction"    value="removeIprouting">
                                                        <input type="hidden" name="subnetid"  value="129459" class="form-control" style="margin-right: 10px">
                                                        <center><button class="removeIprouting btn btn-danger btn-sm">Remove</button></center>
                                                    </form>
                                                </td>
                                            </tr> 
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div id="routevlan" class="tab-pane fade">
                                <br>
                                <form id="addVlanRouteForm" class="form-inline">
                                    <input type="hidden" name="hivelocityAction"    value="addVlanRoute">
                                    <select name="routevlanId" class="routevlanIdselect form-select form-control" style="margin-right: 10px" {$vlanroutedisable}>
                                        <option>Select VLAN</option>
                                        {foreach from = $vlanList item = vlan}
                                            {if !$vlan.portIds}
                                            <option value="{$vlan.vlanId}">VLAN Tag #{$vlan.vlanTag} {$vlan.facilityCode}</option>
                                            {/if}
                                        {/foreach}
                                    </select>
                                    <button id="addVlanRoute" class="btn btn-sm btn-success" {$vlanroutedisable}>Add</button> 
                                </form>
                                <br>
                                <div class="row" style="margin-bottom:5px">
                                    <div class="col">
                                        <table class="table table-striped" id="vlanRouteListTable" style="width:100%" border="1">
                                            <tr>
                                                <th style="text-align: center">Route Vlans</th>
                                                <th></th>
                                            </tr>
                                            {foreach from = $vlanList item = vlan}
                                                {if $vlan.portIds}
                                                <tr>
                                                    <td style="text-align: center">VLAN Tag #{$vlan.vlanTag} {$vlan.facilityCode}</td>
                                                    <td>
                                                        <form id="" action="">
                                                            <input type="hidden" name="hivelocityAction"    value="removeVlanrouting">
                                                            <input type="hidden" name="vlanid"  value="{$vlan.vlanId}" class="form-control" style="margin-right: 10px">
                                                            <center><button class="removeVlanrouting btn btn-sm btn-danger">Remove</button></center>
                                                        </form>
                                                    </td>
                                                </tr> 
                                                {/if}  
                                            {foreachelse}
                                                <tr>
                                                    <td style="width:50%; text-align: center;">Records Not Found</td>
                                                </tr>   
                                            {/foreach}
                                        </table>
                                    </div>
                                </div>

                            </div>
                            
                        </div>    
                    </div>
                </div>        
            </div>  
            <div id="eventLog" class="tab-pane fade">
                <div class="container" style="width:auto">
                    <div class="row" style="margin-bottom:5px"> 
                        <div class="col">
                            <table class="table table-striped" id="" style="width:100%" border="1">
                                <tr>
                                    <th>Event</th>
                                    <th>Status</th>
                                    <th>Finished at</th>
                                </tr>
                                {foreach from = $eventlogs item = log}
                                    <tr>
                                        <td style="text-align: center">{$log.event}</td>
                                        <td style="text-align: center"><div class="badge bg-info rounded-pill">{$log.status}</div></td>
                                        <td style="text-align: center">{$log.date}</td>
                                    </tr>    
                                {/foreach}
                            </table>
                        </div>
                    </div>
                </div>        
            </div>      
        {/if}
    </div>
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
                                <table class="table table-striped" style="width:100%">
                                    <tr>
                                        <td>
                                            <button id="vpnHelpButton" class="btn btn-sm btn-secondary">Use VPN</button>
                                        </td>
                                        <td>
                                            <span style="float:left;">-OR-</span>
                                        </td>
                                        <td>
                                                <form id="allowIpForm" class="form-inline">
                                                    <input type="hidden" name="hivelocityAction"    value="allowIp">
                                                    <input type="text" class="form-control" name="hivelocityIp" value="{$userIp}" style="width:150px; margin-right:4px">
                                                    <button id="allowIpButton" class="btn btn-sm btn-success">Allow IP</button>
                                                </form>
                                                <button id="openIpmiPageButton" class="btn btn-sm btn-success" style="display:none">IPMI Login Page</button>
                                        </td>  
                                        <td>
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
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
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
                    <div id="dnsModalContent">
                        <ul class="nav nav-tabs responsive-tabs-sm">
                            <li class="active nav-item"><a data-toggle="tab" class="nav-link active" href="#tabDnsRecordsA">A</a></li>
                            <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tabDnsRecordsAAAA">AAAA</a></li>
                            <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tabDnsRecordsMX">MX</a></li>
                            <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tabDnsRecordsPTR">PTR</a></li>
                        </ul>
                        <div class="tab-content" style="border-style: solid; border-color: #ddd; padding:5px; padding-top: 20px; border-width: 1px; border-top-style: none;" >
                            <div id="tabDnsRecordsA" class="tab-pane fade in active show">
                                <form>
                                    <table class="table-striped" id="dnsAddRecordATable" style="width:100%">
                                    
                                    </table>
                                </form>
                                <table class="table-striped" id="dnsRecordsATable" style="width:100%">
                                    
                                </table>
                            </div>
                            <div id="tabDnsRecordsAAAA" class="tab-pane fade in">
                                <form>
                                    <table id="dnsAddRecordAAAATable" class="table-striped" style="width:100%">
                                    
                                    </table>
                                </form>
                                <table id="dnsRecordsAAAATable" class="table-striped" style="width:100%">
                                    
                                </table>
                            </div>
                            <div id="tabDnsRecordsMX" class="tab-pane fade in">
                                <form>
                                    <table id="dnsAddRecordMXTable" class="table-striped" style="width:100%">
                                    
                                    </table>
                                </form>
                                <table id="dnsRecordsMXTable" class="table-striped" style="width:100%">
                                    
                                </table>
                            </div>
                            
                            <div id="tabDnsRecordsPTR" class="tab-pane fade in">
                                <table id="dnsRecordsPTRTable" class="table-striped" style="width:100%">
                                    
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <div id="dnsModalContentEditRecord">
                        <form>
                            <table id="dnsEditRecordTable" class="table-striped" style="width:100%">

                            </table>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="requestIp" tabindex="-1" role="dialog" aria-labelledby="requestIpLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestIpLabel">Request More IP Addresses</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container" style="width:auto">
                        <div class="row">
                            <div class="col">
                                <div class="alert alert-info text-center" style="display: none;" id="successmsg"></div>
                                <form id="requestIps" class="">
                                    <input type="hidden" name="hivelocityAction"    value="requestIps">
                                    <input type="hidden" name="device_id"    value="{$deviceId}">

                                    <label style="float: left">IPv4/IPv6 Addresses</label>
                                    <select name="number_requested" class="form-select form-control" style="margin-right: 10px">
                                        <optgroup label="IPv4 Addresses">
                                            <option value="2">/31 = $5.00/month (2 IPs)</option>
                                            <option value="4">/30 = $10.00/month (4 IPs)</option>
                                            <option value="8">/29 = $20.00/month (8 IPs)</option>
                                            <option value="16">/28 = $40.00/month (16 IPs)</option>
                                            <option value="32">/27 = $80.00/month (32 IPs)</option>
                                            <option value="64">/26 = $160.00/month (64 IPs)</option>
                                            <option value="128">/25 = $320.00/month (128 IPs)</option>
                                            <option value="256">/24 = $640.00/month (256 IPs)</option>
                                        </optgroup>
                                        <optgroup label="IPv6 Addresses">
                                            <option value="18,446,744,073,709,551,616">/64 = $2.50/month (18,446,744,073,709,551,616 IPs)</option>
                                            <option value="256 x /64">/56 = $10.00/month (256 x /64 IPs)</option>
                                            <option value="65,536 x /64 IPs">/48 = $50.00/month (65,536 x /64 IPs IPs)</option>
                                            <option value="Custom Allocation Request (Requires Review)"
>(Custom Allocation Request (Requires Review) IPs)</option>
                                        </optgroup>

                                    </select><br>

                                    <label style="float: left">Purpose for requesting new IPs</label>
                                    <textarea class="form-control" name="purpose"></textarea><br>

                                    <!-- <strong>Total: $<span id="totalamount">0.00</span>/month</strong> 
                                    <p>
                                        I agree to pay the above charge(s) according to the card issuer's agreement. I understand that by clicking "Submit" on this form will serve as my authorizations on the credit charges and as a Signature-on-File for all authorized charges and outstanding balances now and in the future. I affirm that all information provided is truthful and accurate and will be responsible for any damages caused by untruthfulness. Furthermore, I agree to the terms and conditions listed at the following pages of the Hivelocity.net website:
                                    </p>
                                    <a href="https://www.hivelocity.net/legal/#billing" target="_blank">Billing Policy</a>&nbsp;
                                    <a href="https://www.hivelocity.net/legal/#tos" target="_blank">Terms of Service</a>&nbsp;
                                    <a href="https://www.hivelocity.net/legal/#acceptable-use-policy" target="_blank">Acceptable Use Policy</a><br><br>-->
                                    
                                    <button style="float: left" id="requestIpButton" class="btn btn-sm btn-success">Request IP</button>
                                </form>
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>    

<style>
    #manage td {
      padding:1px;
    }
</style>                        
                        
<script>
    var hivelocityServiceId = {$serviceId};

    $("#routevlantab").click(function(){
        $('#routeip').hide();
    });

    $("#routeiptab").click(function(){
        $('#routeip').show();
    });
    
</script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />        
<script src="modules/servers/Hivelocity/templates/js/clientArea.js" type="text/javascript"></script>

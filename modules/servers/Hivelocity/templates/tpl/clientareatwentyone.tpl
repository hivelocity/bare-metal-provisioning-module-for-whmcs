{literal}
<style>
    .stat{font-size: 22px !important;}
</style>
{/literal}
<div>
    <div class="alert alert-danger text-center" id="hivelocityMainErrorBox" style="display:none"></div>
    <div class="tiles mb-4" style="text-align: left;">
        <div class="row no-gutters">
            <div class="col-6 col-xl-3">
                <div class="tile">
                    <div class="stat">{$dashboarddetails.location}</div>
                    <div class="title">Device Location</div>
                    <div class="highlight bg-color-blue"></div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="tile">
                    <div class="stat">{$dashboarddetails.renewdate}</div>
                    <div class="title">Next Renew</div>
                    <div class="highlight bg-color-green"></div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="tile">
                    <div class="stat">{$dashboarddetails.monitorsUp} UP</div>
                    <div class="title">Monitoring</div>
                    <div class="highlight bg-color-red"></div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="tile">
                    <div class="stat">0/0 OK</div>
                    <div class="title">Backups</div>
                    <div class="highlight bg-color-gold"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 col-xl-6">
            <div class=""><h4>Service Details</h4><{$servicedetails}</div>
        </div>
        <div class="col-6 col-xl-6">
            <div class=""><h4>Hardware Details</h4><{$hardwaredetails}</div>
        </div>
    </div>
    <hr>
    <ul class="nav nav-tabs responsive-tabs-sm">
        <li class="active nav-item"><a data-toggle="tab" class="nav-link active" href="#tabDetails">Details</a></li>
        {if !$orderStatus}
            <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tabIpAssignments">IP Assignments</a></li>
            <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tabBandwidth">Bandwidth</a></li>
            <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tabIpmi">IPMI</a></li>
        {/if}
    </ul>
    <div class="tab-content" style="border-style: solid; border-color: #ddd; padding:15px; padding-top: 20px; padding-bottom: 20px; border-width: 1px; border-top-style: none;" >
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
                    {/foreach}
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
                <div id="tabBandwidthGraphs">
                </div>  
            </div>
            <div id="tabIpmi" class="tab-pane fade">
                <div class="container" style="width:auto">
                    <div class="row" style="margin-bottom:5px">
                        <div class="col">
                            <h6>IPMI Sensors</h6>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:5px">
                        <div class="col">
                            <table id="" style="width:100%" border="1">
                                {foreach from = $ipmisensors item = sensor}
                                    <tr>
                                        <td style="width:50%; text-align: center;">{$sensor.name}</td>
                                        <td style="width:50%; text-align: center;">{$sensor.unit}</td>
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

<style>
    #manage td {
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

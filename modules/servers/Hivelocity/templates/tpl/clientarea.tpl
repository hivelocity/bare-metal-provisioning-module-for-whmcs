<div>
    <ul class="nav nav-tabs responsive-tabs-sm">
        <li class="active nav-item"><a data-toggle="tab" class="nav-link active" href="#tabDetails">Details</a></li>
        {if !$orderStatus}
            <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tabBandwidth">Bandwidth</a></li>
        {/if}
    </ul>
    <div class="tab-content" style="border-style: solid; border-color: #ddd; padding:5px; padding-top: 20px; border-width: 1px; border-top-style: none;" >
        <div id="tabDetails" class="tab-pane fade in active show">
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
        
        {if !$orderStatus}
        
            <div id="tabBandwidth" class="tab-pane fade">
                <div class="row" style="margin-bottom:5px">
                    <table style="margin: auto;">
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
                        
                <div id="customPeriodDiv" class="row" hidden style="margin-bottom:5px">
                    <table style="margin: auto;">
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

                <img src="admin/images/loading.gif" id="graphLoader" class="" style="display: none;">
                <img id="bandwidthGraphImage" src="modules/servers/Hivelocity/graph.php?hivelocityServiceId={$serviceId}" alt="Graph" style="max-width:100%">
            </div>
        {/if}
    </div>
</div>    

<script>
    var hivelocityServiceId = {$serviceId};
</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />        
<script src="modules/servers/Hivelocity/templates/js/clientArea.js" type="text/javascript"></script>
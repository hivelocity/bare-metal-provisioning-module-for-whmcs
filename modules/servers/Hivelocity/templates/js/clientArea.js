$(document).ready(function() {
   
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
});

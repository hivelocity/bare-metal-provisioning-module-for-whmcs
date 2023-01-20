$(document).ready(function() {
    
    $('.hivelocityPriceTable').DataTable({
        "order": [],
        'columnDefs': [{
                "targets": [-1,-2],
                "orderable": false
        }]
    });
    
    onCurrencyChange();
    
    $("#currencySelect").change(function() {
        onCurrencyChange();
    });

    
    $(".priceField").change(function() {
        var field = $(this);
        onPriceChange(field);
    });
    
    
    $(".profitField").change(function() {
        var field = $(this);
        onProfitChange(field);
    });
    
    
    $("#globalProfit").change(function() {
        var field = $(this);
        onGlobalProfitChange(field);
    });
    
    
    $("#saveButton").click(function() {
        var formDiv             = $(".priceForm:visible");
        var submitButton        = formDiv.find(":submit");
        submitButton.click();
    });



    $('#DataTables_Table_0_wrapper').on( 'page.dt', function () {
        
        $( "#currencySelect").unbind( "change" ); 
        $( ".priceField").unbind( "change" );
        $( ".profitField").unbind( "change" );
        $( "#globalProfit").unbind( "change" );
        $( "#saveButton").unbind( "click" );
        
        setTimeout(function() { 
            onCurrencyChange();
            
            $("#currencySelect").change(function() {
                onCurrencyChange();
            });
            
            $(".priceField").change(function() {
                var field = $(this);
                onPriceChange(field);
            });
            
            $(".profitField").change(function() {
                var field = $(this);
                onProfitChange(field);
            });
            
            $("#globalProfit").change(function() {
                var field = $(this);
                onGlobalProfitChange(field);
            });
            
            $("#saveButton").click(function() {
                var formDiv             = $(".priceForm:visible");
                var submitButton        = formDiv.find(":submit");
                submitButton.click();
            });

        }, 1000);

    });

});


function onCurrencyChange() {
    var selectedCurrencyId = $("#currencySelect").val();
    $(".priceForm").hide();
    $("#priceForm" + selectedCurrencyId).show();
}

function onPriceChange(field) {  
    var row = field.parent().parent();
    
    var localPrice          = parseFloat(field.val());
    var remotePrice         = parseFloat(row.find(".remotePriceField").val());
    var profitField         = row.find(".profitField");
    
    var profit              = localPrice - remotePrice;
    var profitPercentage    = (profit / remotePrice) * 100;
    profitPercentage        = profitPercentage.toFixed(2);
    
    
    profitField.val(profitPercentage);
}

function onProfitChange(field) { 
    var row = field.parent().parent();
    
    var profitPercentage    = parseFloat(field.val());
    var remotePrice         = parseFloat(row.find(".remotePriceField").val());
    var localPriceField     = row.find(".priceField");
    var profit              = (remotePrice * profitPercentage) / 100;
    var localPrice          = remotePrice + profit;
    
    localPriceField.val(localPrice);
}

function onGlobalProfitChange(field) {
    
    var formDiv             = $(".priceForm:visible");
    var profitField         = formDiv.find(".profitField");
    profitField.val(field.val()).trigger("change");
    $("input[name=globalchange]").val('true');
    $("input[name=globalprofit]").val(field.val());
    field.val("");
}


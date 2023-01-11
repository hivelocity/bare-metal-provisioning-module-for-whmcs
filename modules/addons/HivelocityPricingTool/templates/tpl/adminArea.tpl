{if $success}
    <div class="successbox"><strong><span class="title">Changes Saved Successfully!</span></strong><br>Your changes have been saved.</div>
{/if}

{if $error}
    <div class="errorbox"><strong><span class="title">Error!</span></strong><br>$error.</div>
{/if}

<div>
    <table style="margin-bottom: 20px">
        <thead>
            <tr>
                <th>Currency</th>
                <th>Profit</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding-right: 20px">
                    <select id = "currencySelect" class = "form-control">
                        {foreach from = $currencyList key = currencyId item = currencyData}
                            <option value = "{$currencyId}">{$currencyData.suffix}</option>
                        {/foreach}
                    </select>
                </td>
                <td>
                    <input id = "globalProfit" type = "text" class = "form-control input-inline input-100"> %
                </td>
                <td>
                    <button type="button" id = "saveButton" class = "btn btn-primary" style = "margin-left:20px">Save</button>
                </td>
                <td>
                    &nbsp;&nbsp;<a href="/admin/addonmodules.php?module=HivelocityPricingTool&action=generateproducts" class="btn btn-primary">Sync Products</a>
                </td>

            </tr>
        </tbody>
    </table>
             
    {foreach from = $currencyList key = currencyId item = currencyData}
        <div id = "priceForm{$currencyId}" class = "priceForm" hidden>
            <form method="post" action="">
                <input type = "hidden"  name = "hivelocityPricingToolAction"  value = "updatePricing">
                <input type = "hidden"  name = "currencyId"  value = "{$currencyId}"  >
                <table class="table hivelocityPriceTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Remote Price</th>
                            <th>Local Price</th>
                            <th>Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        {assign var = counter value = 0}
                        {foreach from = $productList key = productId item = productData}
                            {if $productData.localPrice.$currencyId == -1}
                                {continue}
                            {/if}
                            <tr>
                                <td><input type = "hidden"  name = "productId[{$counter}]"  value = "{$productId}"  >{$productId}</td>
                                <td>{$productData.name}</td>
                                <td><input type = "hidden"                                      value = "{$productData.remotePrice.$currencyId}" class = "remotePriceField"   >{$productData.remotePrice.$currencyId} {$currencyData.suffix}</td>
                                <td><input type = "text"    name = "localPrice[{$counter}]"     value = "{$productData.localPrice.$currencyId}"  class = "form-control input-inline input-100 priceField"   > {$currencyData.suffix}</td>
                                <td><input type = "text"                                        value = "{$productData.profit.$currencyId}"      class = "form-control input-inline input-100 profitField"  > %</td>
                            </tr>
                            {assign var = counter value = $counter + 1}
                        {/foreach}
                    </tbody>
                </table>
                <input type = "submit" value = "Save" class = "btn btn-primary" style = "margin: auto; visibility: hidden;">
           </form>
       </div>         
   {/foreach}
   
</div>    
       
<script src="../modules/addons/HivelocityPricingTool/templates/js/adminArea.js" type="text/javascript"></script>
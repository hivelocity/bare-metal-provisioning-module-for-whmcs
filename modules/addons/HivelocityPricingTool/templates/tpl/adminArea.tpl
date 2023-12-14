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
                    &nbsp;&nbsp;<a {if !$disabled} href="/admin/addonmodules.php?module=HivelocityPricingTool&action=generateproducts" {/if} class="btn btn-primary" {$disabled}>Sync Products</a>
                </td>
            </tr>
            
            {if $crondisable}
                <tr>
                    <td colspan=4><br>
                        <div class="alert alert-danger">{$crondisable}</div>
                    </td>

                </tr>
            {/if}

            {if $disabledmsg}
                <tr>
                    <td colspan=4><br>
                        <div class="alert alert-info">{$disabledmsg}</div>
                    </td>

                </tr>
            {/if}
            
        </tbody>
    </table>
    <table style="margin-bottom: 10px">
        <tbody>
            <tr>
              <td>Active: {$activeProducts}</td>
            </tr>
            <tr>
              <td>Out of stock: {$hiddenProducts}</td>
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
                            <th>Status</th>
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
                                <td><input type = "hidden" value = "{$productData.remotePrice.$currencyId}" class = "form-control input-inline input-100 remotePriceField"   >{$productData.remotePrice.$currencyId} {$currencyData.suffix}</td>
                                <td><input type = "text"    name = "localPrice[{$counter}]"     value = "{$productData.localPrice.$currencyId}"  class = "form-control input-inline input-100 priceField"   > {$currencyData.suffix}</td>
                                <td>{if $productData.hidden === 1}Out of stock{else}Active{/if}</td>
                                <td><input type = "text" value = "{$productData.profit.$currencyId}"      class = "form-control input-inline input-100 profitField"  > %</td>
                            </tr>
                            {assign var = counter value = $counter + 1}
                        {/foreach}
                    </tbody>
                </table>
                <input type='hidden' name='globalprofit' value=''>
                <input type='hidden' name='globalchange' value=''>
                <input type = "submit" value = "Save" class = "btn btn-primary" style = "margin: auto; visibility: hidden;">
           </form>
       </div>         
   {/foreach}
   
</div>    
       
<script src="../modules/addons/HivelocityPricingTool/templates/js/adminArea.js" type="text/javascript"></script>

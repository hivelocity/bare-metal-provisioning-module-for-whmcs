<div class="lu-app-main">
    <div class="lu-app-main__body">

        <div id="" class="vue-app-main-container">
            <div class="lu-row">
                <div class="lu-widget">
                    <div class="lu-widget__body">
                        <div style="padding: 20px;">
                            <div class="row">

                                <div class="col-sm-12 col-xs-12"> 
                                    <h2>Banners</h2> <hr>
                                    <a href="{$systemurl}?module=HivelocityTheme&page=addbanner" class="btn btn--primary" style="float:right;">Add New</a><br>
                                </div>
                                <div class="col-sm-12 col-xs-12"> 
                                    <div class="dataTables_wrapper no-footer"> 
                                        <div>
                                            <table width="100%" role="grid" class="lu-table lu-table--mob-collapsible dataTable no-footer dtr-column">  
                                                <thead>
                                                    <tr role="row">
                                                        <th aria-sort="descending" name="id" class=" "><span class="lu-table__text">Banner&nbsp;&nbsp;</span></th> 
                                                        <th aria-sort="descending" name="id" class=" "><span class="lu-table__text">Heading&nbsp;&nbsp;</span></th> 
                                                        <th aria-sort="descending" name="id" class=" "><span class="lu-table__text">action&nbsp;&nbsp;</span></th> 
                                                    </tr>
                                                </thead> 
                                                <tbody>
                                                {foreach from=$banners item=v}
                                                    <tr role="row"> 
                                                        <td><img src="{$domain}/modules/addons/HivelocityTheme/assets/img/{$v['banner']}" width="200" height="100"></td>
                                                        <td>{$v['heading']}</td>
                                                        <td><a href="{$systemurl}?module=HivelocityTheme&page=addbanner&bid={$v['id']}&action=edit" class="btn-sm btn--warning"><i class="fa fa-pencil"></i></a>
                                                        <a onclick="return confirm('Are you sure you want to delete?')" href="{$systemurl}?module=HivelocityTheme&page=banners&bid={$v['id']}&action=delete" class="btn-sm btn--danger"><i class="fa fa-trash"></i></a>
                                                    </tr>
                                                {/foreach}
                                                </tbody>
                                            </table> 
                                            {if empty($banners)}
                                                <div style="padding: 15px; text-align: center; border-top: 1px solid rgb(233, 235, 240);">
                                                    No Data Available
                                                </div> 
                                            {/if}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
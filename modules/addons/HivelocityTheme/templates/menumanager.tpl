<div class="lu-app-main">
    <div class="lu-app-main__body">

        <div id="" class="vue-app-main-container">
            <div class="lu-row">
                <div class="lu-widget">
                    <div class="lu-widget__body">
                        <div style="padding: 20px;">
                            <div class="row">

                                <div class="col-sm-12 col-xs-12"> 
                                    <h2>Header Menu</h2> <hr>
                                    <a href="{$systemurl}?module=HivelocityTheme&page=addmenu" class="btn btn--primary" style="float:right;">Add New</a><br>
                                </div>
                                <div class="col-sm-12 col-xs-12"> 
                                    <div class="dataTables_wrapper no-footer"> 
                                        <div>
                                            <table width="100%" role="grid" class="lu-table lu-table--mob-collapsible dataTable no-footer dtr-column">  
                                                <thead>
                                                    <tr role="row">
                                                        <th aria-sort="descending" name="id" class=" "><span class="lu-table__text">Name&nbsp;&nbsp;</span></th> 
                                                        <th aria-sort="descending" name="id" class=" "><span class="lu-table__text">Parent&nbsp;&nbsp;</span></th> 
                                                        <th aria-sort="descending" name="id" class=" "><span class="lu-table__text">Status&nbsp;&nbsp;</span></th> 
                                                        <th aria-sort="descending" name="id" class=" "><span class="lu-table__text">action&nbsp;&nbsp;</span></th> 
                                                    </tr>
                                                </thead> 
                                                <tbody>
                                                {foreach from=$menus item=v}
                                                    <tr role="row"> 
                                                        <td>{$v['name']}</td>
                                                        <td>{if $v['parent']}{$v['parent']}{else}-{/if}</td>
                                                        <td>{$v['status']}</td>
                                                        <td><a href="{$systemurl}?module=HivelocityTheme&page=addmenu&menuid={$v['id']}&menuact=edit" class="btn-sm btn--warning"><i class="fa fa-pencil"></i></a>
                                                        <a onclick="return confirm('Are you sure you want to delete?')" href="{$systemurl}?module=HivelocityTheme&page=menumanager&menuid={$v['id']}&menuact=delete" class="btn-sm btn--danger"><i class="fa fa-trash"></i></a>
                                                    </tr>
                                                {/foreach}
                                                </tbody>
                                            </table> 
                                            {if empty($menus)}
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
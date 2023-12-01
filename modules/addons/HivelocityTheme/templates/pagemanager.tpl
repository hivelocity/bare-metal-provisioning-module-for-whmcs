<div class="lu-app-main">
    <div class="lu-app-main__body">

        <div id="" class="vue-app-main-container">
            <div class="lu-row">
                <div class="lu-widget">
                    <div class="lu-widget__body">
                        <div style="padding: 20px;">
                            <div class="row">

                                <div class="col-sm-12 col-xs-12"> 
                                    <h2>All Pages</h2> <hr>
                                    <a href="{$systemurl}?module=HivelocityTheme&page=addpage" class="btn btn--primary" style="float:right;">Add Page</a><br>
                                </div>
                                <div class="col-sm-12 col-xs-12"> 
                                    <div class="dataTables_wrapper no-footer"> 
                                        <div>
                                            <table width="100%" role="grid" class="lu-table lu-table--mob-collapsible dataTable no-footer dtr-column">  
                                                <thead>
                                                    <tr role="row">
                                                        <th aria-sort="descending" name="id" class=" "><span class="lu-table__text">Page Name&nbsp;&nbsp;</span></th> 
                                                        <th aria-sort="descending" name="id" class=" "><span class="lu-table__text">Status&nbsp;&nbsp;</span></th> 
                                                        <th aria-sort="descending" name="id" class=" "><span class="lu-table__text">action&nbsp;&nbsp;</span></th> 
                                                    </tr>
                                                </thead> 
                                                <tbody>
                                                {foreach from=$pages item=v}
                                                    <tr role="row"> 
                                                        <td>{$v['name']}</td>
                                                        <td><span class="badge badge--{if $v['publish'] eq '1'}success{else}warning{/if}">{if $v['publish'] eq '1'}Published{else}Draft{/if}</span></td>
                                                        <td><a href="{$systemurl}?module=HivelocityTheme&page=addpage&pageid={$v['id']}&pageact=edit" class="btn-sm btn--warning"><i class="fa fa-pencil"></i></a>
                                                        <a onclick="return confirm('Are you sure you want to delete?')" href="{$systemurl}?module=HivelocityTheme&page=pagemanager&pageid={$v['id']}&pageact=delete" class="btn-sm btn--danger"><i class="fa fa-trash"></i></a>
                                                    </tr>
                                                {/foreach}
                                                </tbody>
                                            </table> 
                                            {if empty($pages)}
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
mgJsComponentHandler.addDefaultComponent('mg-datatable', {
    template : '#t-mg-datatable',
    props: [
        'component_id',
        'component_namespace',
        'component_index',
        'autoload_data_after_created',
        'start_length'
    ],
    data : function() {
        return {
            dataRows: [],
            length: 10,
            iSortCol_0 : '',
            sSortDir_0 : '',
            addTimeout : false,
            sSearch : false,
            sSearchPrevious : false,
            dataShowing : 0,
            dataTo : 0,
            dataFrom : 0,
            curPage : 1,
            allPages : 1,
            pagesMap : [],
            loading : false,
            show : true,
            showModal : false,
            noData : false,
            onOffSwitchEnabled : false,
            children: [],
            searchEnabled: true
        };
    },
    created: function () {
        var self = this;
        self.length = self.start_length;
        this.addTimeout = true;
        if (this.autoload_data_after_created) {
            this.updateProjects();
        }
        
        this.$parent.$root.$on('reloadMgData', this.updateMgData);
        mgEventHandler.on('DatatableFilterUpdated', self.component_id, function(id, params){
            self.checkRequiredFilters();
        });
        this.$nextTick(function(){
            this.checkRequiredFilters();
        });
    },
    updated: function (){
        var self = this;        
        initMassActionsOnDatatables(self.component_id);
        initTooltipsForDatatables(self.component_id);
    },
    methods: {
        checkRequiredFilters: function() {
            var requiredFilters = this.$store.getters.getComponentData(this.component_id, 'requiredFilters');
            if (typeof requiredFilters === 'object'){
                this.searchEnabled = true;
                for (var key in requiredFilters) {
                    if (!requiredFilters.hasOwnProperty(key)) {
                        continue;
                    }
                    if (requiredFilters[key] === true) {
                        this.searchEnabled = false;
                    }
                }
            }
        },
        updateMgData: function(toReloadId){
            var self = this;
            if(self.component_id === toReloadId){
                self.updateProjects();
                self.$nextTick(function() {
                    self.$emit('restartRefreshingState');
                });
            }
        },
        updateProjects: function(){
            var self = this;
            self.loading = true;
            var resp = self.$parent.$root.$options.methods.vloadData(
                {
                    loadData : self.component_id,
                    namespace : self.component_namespace,
                    index: self.component_index,
                    iDisplayLength : self.length,
                    iDisplayStart : self.dataShowing,
                    sSearch : (self.sSearch !== false ? self.sSearch : ''),
                    iSortCol_0 : self.iSortCol_0,
                    sSortDir_0 : self.sSortDir_0,
                    filters: self.getFilters()
                });
            resp.done(function(data){
                if (data.data.status === 'error') {
                    self.noData = true;
                    mgPageControler.vueLoader.handleErrorMessage(data.data);
                } else {
                    var actionData = data.data.rawData;
                    data = data.data.rawData.recordsSet;
                    if( typeof data.records == "undefined"){
                        data.records =[];
                    }
                    if (data.records.length === 0 && self.dataShowing > 0) {
                        self.dataShowing = 0;
                        return self.updateProjects();
                    }
                    self.dataRows  = data.records;
                    self.runCalbacks(actionData);
                    mgEventHandler.runCallback('DatatableDataLoaded', self.component_id, {data: data.records, datatable: self});
                    self.dataShowing = data.offset;
                    self.dataTo = data.records.length + data.offset;
                    self.dataFrom = data.fullDataLenght;
                    self.addTimeout = false;
                    if(self.addTimeout === true){
                        setTimeout(self.updateProjects, 60000);
                        self.addTimeout = false;
                    }
                    self.noData = data.records.length > 0 ? false : true;
                }
                self.updatePagination();
                self.loading = false;
            }).fail(function(jqXHR, textStatus, errorThrown) {
                self.loading = false;
                self.dataRows = [];
                self.noData = true;
                mgEventHandler.runCallback('DatatableDataLoadingFailed', self.component_id, {jqXHR: jqXHR, textStatus: textStatus, errorThrown: errorThrown});
                mgPageControler.vueLoader.handleServerError(jqXHR, textStatus, errorThrown);
            });
            uncheckSelectAllCheck(self.tableWrapperId);
        },
        runCalbacks: function(data) {
            var self = this;
            if (typeof data.recordsSet !== 'undefined' && typeof data.recordsSet.records !== 'undefined' && data.recordsSet.records.length > 0)
            {
                $('#loadedTemplates').append(data.template);
                self.$nextTick(function() {
                    for (var key in data.registrations) {
                        mgJsComponentHandler.extendRegisterByDefaultTemplate(key.toLowerCase(), data.registrations[key]);
                    }
                });
            }
        },
        updateLength: function(event){
            var self = this;
            var btnTarget = (typeof $(event.target).attr('data-length') === 'undefined') ? $(event.target).parent() : $(event.target);
            self.length = $(btnTarget).attr('data-length');
            self.dataShowing = 0;
            $(btnTarget).parent().children('.active').removeClass('active');
            $(btnTarget).addClass('active');
            self.updateProjects();
        },
        updateSorting: function(event){
            var self = this;
            var sortTarget = $(event.target)[0].tagName === 'TH' ? $(event.target) : $(event.target).parents('th').first();
            self.iSortCol_0 = $(sortTarget).attr('name');
            self.dataShowing = 0;
            var currentDir = self.getSortDir($(sortTarget), true);
            $(event.target).parents('tr').first().children('.sorting_asc, .sorting_desc').addClass('sorting').removeClass('sorting_asc').removeClass('sorting_desc');
            $(sortTarget).removeClass('sorting').removeClass('sorting_asc').removeClass('sorting_desc').addClass(self.reverseSort(currentDir));
            self.sSortDir_0 = self.getSortDir($(sortTarget), false);
            self.updateProjects();
        },
        reverseSort: function(sort){
            var sortingType = 'sorting_asc';
            if(sort === 'sorting_asc'){
                sortingType = 'sorting_desc';
            }
            return sortingType;
        },
        getSortDir: function(elem, rawClass){
            var sorts = ['sorting_asc', 'sorting_desc', 'sorting'];
            var sorting = '';
            $.each(sorts, function(key, sort) {
                if($(elem).hasClass(sort) === true) {
                    sorting = rawClass ? sort : sort.replace('sorting_', '').replace('sorting', '');
                    return sorting;
                }
            });
            return sorting;
        },
        searchDataEnter: function(event){
            event.preventDefault();
            this.searchData(event);
        },
        searchData: function(event){
            var self = this;
            self.sSearch = $(event.target).val() === '' ? false : $(event.target).val();
            if (self.sSearch !== false) {
                if (self.sSearchPrevious !== false && self.sSearchPrevious !== self.sSearch) {
                    self.dataShowing = 0;
                }
                self.sSearchPrevious = self.sSearch;
            } else {
                self.sSearchPrevious = false;
            }
            self.updateProjects();
        },
        updatePagination: function(){
            var self = this;
            self.curPage = (parseInt(self.dataShowing) / parseInt(self.length)) + 1;
            var tempPages = parseInt(parseInt(self.dataFrom) / parseInt(self.length));
            self.allPages = parseInt(tempPages + ((parseInt(self.length) * tempPages) < parseInt(self.dataFrom) ? 1 : 0));
            self.updatePagesMap();
        },
        updatePagesMap: function(){
            var self = this;
            if (self.allPages === 1) {
                self.pagesMap = [1];
                return;
            }
            self.pagesMap = [
                self.curPage -5,
                self.curPage -4,
                self.curPage -3,
                self.curPage -2,
                self.curPage -1,
                self.curPage,
                self.curPage +1,
                self.curPage +2,
                self.curPage +3,
                self.curPage +4,
                self.curPage +5
            ];
            for(i=0; i< self.pagesMap.length; i++){
                if(self.pagesMap[i] < 0 || self.pagesMap[i] > self.allPages){
                    self.pagesMap[i] = null;
                }
            }

            if(self.pagesMap.indexOf(self.allPages) === -1) {
                self.pagesMap[self.pagesMap.length-1] = self.allPages;
            }
            if(self.pagesMap.indexOf(1) === -1) {
                self.pagesMap[0] = 1;
            }

            if(self.allPages > 7 && self.curPage > 4) {
                self.pagesMap[self.pagesMap.indexOf(Math.min(
                    self.curPage-1 > 1 ? self.curPage-1 : self.curPage,
                    self.curPage-2 > 1 ? self.curPage-2 : self.curPage,
                    self.curPage-3 > 1 ? self.curPage-3 : self.curPage,
                    self.curPage-4 > 1 ? self.curPage-4 : self.curPage
                ))] = '...';
            }

            for(i=self.pagesMap.length-1; i > self.pagesMap.indexOf(self.curPage); i--){
                if(i === 8 && self.pagesMap[i] === self.curPage + 3 && self.pagesMap[i] !== self.allPages) {
                    self.pagesMap[i] = null;
                }
            }
            if(self.allPages > 7 && (4 <= self.allPages - self.curPage)) {
                self.pagesMap[self.pagesMap.indexOf(self.allPages) - 1] = '...';
            }
        },
        changePage: function(event) {
            var self = this;
            if($(event.target).parent().hasClass('disabled') === false && $(event.target).hasClass('disabled') === false){
                var newPageNumber = $(event.target).attr('data-dt-idx');
                self.dataShowing = ((newPageNumber < 1) ? 0 : newPageNumber -1) * parseInt(self.length);
                self.updateProjects();
            }
        },
        rowDrow : function(name, DataRow, customFunctionName) {
            if(window[customFunctionName] === undefined) {
                return DataRow[name];
            } else {
                return window[customFunctionName](name, DataRow);
            }
        },
        loadModal: function(event, targetId, namespace, index, params, addSpinner){
            mgPageControler.vueLoader.loadModal(event, targetId,
                typeof namespace !== 'undefined' ? namespace : getItemNamespace(targetId),
                typeof index !== 'undefined' ? index : getItemIndex(targetId), params, addSpinner);
        },
        onOffSwitch: function(event, targetId){
            var switchPostData = $(event.target).is(':checked') ? {'value' : 'on'} : {'value' : 'off'};
            mgPageControler.vueLoader.ajaxAction(event, targetId, getItemNamespace(targetId), getItemIndex(targetId), switchPostData);
        },
        redirect :  function (event, params, targetBlank) {
            mgPageControler.vueLoader.redirect(event, params, targetBlank);
        },
        getFilters: function () {
            return this.$store.getters.getComponentData(this.component_id, 'filters');
        }
    }
});

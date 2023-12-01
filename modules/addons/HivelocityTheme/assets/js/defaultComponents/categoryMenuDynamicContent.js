/*
 * Left category menu, right content
 */

/*
 * Empty container for reload contents //mg-emptyContainer
 */
mgJsComponentHandler.addDefaultComponent('category-empty-container', {
    template : '#category-menu',
    data : function(){
        return {
            contentLoading : true
        };
    }
});

/*
 * Empty container registred by default
 */
mgJsComponentHandler.addComponentByDefaultTemplate('empty-menu-cont', 'category-empty-container');

/*
 * Menu and reloads logic
 */
mgJsComponentHandler.addDefaultComponent('category-menu', {
    template : '#mg-category-menu',
    data : function(){
        var self = this;
        return {
            tableWrapperId: 'mg-category-menu',
            returnedData : [],
            targetid : null,
            menuLoading : false,
            sSearch : null,
            dataContent : '',
            showModal : false,
            contentContainerName : 'mg-component-body-empty-menu-cont' ,//+ self.component_id,
            modalBodyContainer : 'mg-modal-body',
            showSearch : false,
            showNoGroups : false,
            activeGroupId: null
        };
    },
    props: ['makeCustomAction', 'toggleFormSection', 'component_id'],
    mounted: function () {
        this.loadCategories(this.loadCategories);
    },
    created: function () {
        var self = this;
        self.$parent.$root.$on('reloadMgData', this.updateMgData);
    },
    methods: {
        updateMgData : function (toReloadId, customParams) {
            var self = this;
            self.activeGroupId = (customParams && typeof customParams.activeGroupId !== undefined) ? customParams.activeGroupId : null;
            if(self.component_id === toReloadId){
                self.loadCategories(true);
                self.$nextTick(function() {
                    self.$emit('restartRefreshingState');
                });
            }
        },
        reloadMenuContent : function(categoryId, namespace, index){
            if($("#groupList").attr("isBeingSorted")) {
                $("#groupList").removeAttr("isBeingSorted");
                return;
            }
            var self = this;
            self.contentContainerName = 'mg-component-body-empty-menu-cont';
            var resp = self.$parent.$options.methods.vloadData({loadData : categoryId, namespace : namespace, index : index});
            resp.done(function(data){
                var data = data.data.rawData;

                $('#loadedTemplates').append(data.template);
                for (var key in data.registrations) {
                    if (!data.registrations.hasOwnProperty(key)) {
                        continue;
                    }
                    mgJsComponentHandler.registerNowByDefaultTemplate(key.toLowerCase(), data.registrations[key]);
                }

                $('#groupList').find('li.is-active').removeClass('is-active');
                $('#groupList').find('#'+categoryId).addClass('is-active');
                self.contentContainerName = 'mg-templatecontainer';
                Vue.component('mg-templatecontainer', {
                    template: data.htmlData,
                    created: function () {
                        var self = this;
                        self.$nextTick(function(){
                            initContainerSelects('itemContentContainer');
                            initContainerTooltips('itemContentContainer');
                        });
                    },
                    methods: {
                        submitForm: function(targetId, event) {
                            mgPageControler.vueLoader.submitForm(targetId, event);
                        },
                        loadModal: function(event, targetId, namespace, index, params, addSpinner) {
                            mgPageControler.vueLoader.loadModal(event, targetId, namespace, index, params, addSpinner);
                        },
                        selectChangeAction: function($event){
                            mgPageControler.vueLoader.selectChangeAction($event);
                        },
                        makeCustomAction: function(functionName, params, event, namespace, index){
                            mgPageControler.vueLoader.makeCustomAction(functionName, params, event, namespace, index);
                        }
                    }
                });
                mgPageControler.vueLoader.$nextTick(function() {
                    $('#itemContentContainer [data-content-slider]').luContentSlider();
                });
                self.$nextTick(function() {
                    tldCategoriesSortableController();
                    mgEventHandler.runCallback('CategoryMenuContentDataLoaded', self.component_id, {data: data, categoryMenu: self});
                });
            });
        },
        searchDataEnter: function(event){
            event.preventDefault();
            this.searchData(event);
        },
        searchData : function(){
            this.loadCategories();
        },
        hideSearch : function(){
            var self = this;
            if (self.sSearch) {
                self.sSearch = null;
                self.loadCategories();
            }
        },
        loadCategories : function(callback){
            var self = this;
            self.menuLoading = true;
            self.targetid = self.$el.attributes.getNamedItem('targetid').value;
            var reqParams = {loadData : self.targetid , namespace : getItemNamespace(self.targetid), index : getItemIndex(self.targetid)};
            if(self.sSearch !== null){
                reqParams.sSearch = self.sSearch;
            }
            var resp = self.$parent.$options.methods.vloadData(reqParams);
            resp.done(function(data){
                self.returnedData = data.data.rawData;
                self.menuLoading = false;
                if (typeof data.data.rawData != 'undefined' && data.data.rawData.length > 0) {
                    if(callback){
                        if (self.activeGroupId) {
                            for (var key in data.data.rawData) {
                                if (!data.data.rawData.hasOwnProperty(key)) {
                                    continue;
                                } else {
                                    if (data.data.rawData[key].elId === self.activeGroupId) {
                                        self.activeGroupId = null;
                                        self.reloadMenuContent(data.data.rawData[key].elId, data.data.rawData[key].namespace, data.data.rawData[key].id);
                                        break;
                                    }
                                }
                            }

                        } else {
                            self.reloadMenuContent(data.data.rawData[0].elId, data.data.rawData[0].namespace, data.data.rawData[0].id);
                        }
                    }
                    self.showNoGroups = false;
                } else {
                    self.showNoGroups = true;
                }
                self.$nextTick(function() {
                    tldCategoriesSortableController();
                });
            });
        },
        loadModal : function(event, targetId, namespace, index, params, addSpinner) {//needs refactoring
            event.stopImmediatePropagation();
            mgPageControler.vueLoader.loadModal(event, targetId, namespace, index, params, addSpinner);
        },
        submitForm: function(event) {
            mgPageControler.vueLoader.submitForm('itemContentContainer', event);
        },
        toggleSearch: function() {
            this.showSearch = !this.showSearch;
        }
        // },
        // makeCustomAction: function (functionName, params, event, namespace, index) {
        //     mgPageControler.vueLoader.makeCustomAction(functionName, params, event, namespace, index);
        // }
    }
});

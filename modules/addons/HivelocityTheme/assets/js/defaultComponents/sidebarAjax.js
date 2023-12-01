mgJsComponentHandler.addDefaultComponent('mg-ajax-sidebar', {
    template : '#t-mg-ajax-sidebar',
    props: [
        'component_id',
        'component_namespace',
        'component_index'
    ],
    data : function() {
        return {
            items: [],
            event: null,
            sidebarLoading: true
        };
    },
    created: function () {
        var self = this;
        self.$nextTick(function() {
            self.loadAjaxData();
        });
    },
    methods: {
        runClickAction: function($event, actionData) {
            var self = this;
            self.event = $event;
            if (typeof mgPageControler.vueLoader[actionData.action] === 'function') {
                mgPageControler.vueLoader[actionData.action](
                    self.parseParam(actionData.params[0]),
                    self.parseParam(actionData.params[1]),
                    self.parseParam(actionData.params[2]),
                    self.parseParam(actionData.params[3]),
                    self.parseParam(actionData.params[4])
                );
            } else if (typeof window[actionData.action] === 'function') {
                window[actionData.action](
                    self.parseParam(actionData.params[0]),
                    self.parseParam(actionData.params[1]),
                    self.parseParam(actionData.params[2]),
                    self.parseParam(actionData.params[3]),
                    self.parseParam(actionData.params[4])
                );
            } else {
                console.log('Action Failed');
            }
        },
        parseParam: function(param) {
            var self = this;
            if (param === '$event') {
                return self.event;
            }

            return param;
        },
        loadAjaxData: function() {
            var self = this;
            self.loading_state = true;

            var requestParams = {
                loadData: self.component_id,
                namespace: self.component_namespace,
                index: self.component_index
            };

            var response = mgPageControler.vueLoader.vloadData(requestParams);
            return response.done(function(data){
                self.items = data.data.rawData;
                self.sidebarLoading = false;
            }).fail(function(){
               self.sidebarLoading = false;
            });
        }
    }
});

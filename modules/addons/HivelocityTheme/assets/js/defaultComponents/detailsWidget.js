/*
 * @author Artur Pilch <artur.pi@modulesgarden.com>
 */

mgJsComponentHandler.addDefaultComponent('mg-details-widget', {
    template : '#t-mg-details-widget',
    props: [
        'component_id',
        'component_namespace',
        'component_index'
    ],
    data : function() {
        return {
            data: false,
            title: '',
            loading_state: false,
        };
    },
    created: function () {
        var self = this;
        self.$nextTick(function() {
            self.loadAjaxData();
        });
    },
    methods: {
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
                self.data = data.data.rawData.data;
                self.title = data.data.rawData.title;
                self.loading_state = false;
            }).fail(function(){
                self.loading_state = false;
            });
        }
    }
});

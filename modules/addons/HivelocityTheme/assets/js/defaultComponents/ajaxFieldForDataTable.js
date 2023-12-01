if (typeof mgDtAjaxCpWrappers === 'undefined') { 
    var mgDtAjaxCpWrappers = {
        ajaxComponents: {},
        updateInProgress: false,
        registerAjaxComponent: function(object) {
            var self = this;
            var tmpAjaxObj = {
                obj: object,
                status: 'notStarted'
            };
            
            self.ajaxComponents[object.component_id] = tmpAjaxObj;
            setTimeout(function() {
                self.loadAjaxData();
            }, 100);
        },
        loadAjaxData: async function() {
            var self = this;
            if (self.updateInProgress) {
                return true;
            }
            self.updateInProgress = true;
            for (var key in self.ajaxComponents) {
                if (!self.ajaxComponents.hasOwnProperty(key)) {
                    continue;
                }
                if (self.ajaxComponents[key].status !== 'notStarted') {
                    continue;
                }
               
               await self.getPromise(key).then(function(){
                   self.ajaxComponents[key].status = 'completed';
               });
            }
        },
        getPromise: function(key) {
            var self = this;
            return new Promise(function(resolve, reject) {
                self.ajaxComponents[key].obj.loadAjaxData().then(function(data){
                    resolve();
                });
            });
        },
        getUnloadedKey: function () {
            var self = this;
            for (var key in self.ajaxComponents) {
                if (!self.ajaxComponents.hasOwnProperty(key)) {
                    continue;
                }
                if (self.ajaxComponents[key].status === 'notStarted') {
                    return key;
                }                
            }
            
            return false;
        }
    };
}

mgJsComponentHandler.addDefaultComponent('dt-ajax-field', {
    template: '#t-dt-ajax-field',
    data: function () {
        return {
            component_id: null,
            component_namespace: null,
            component_index: null,
            wrapper_id: null,
            loading_async: null,
            loading_lang: null,
            data: {},
            loading_state: true
        };
    },
    mounted: function () {
        var self = this;
        var wrapper = $(self.$el).parent();
        self.wrapper_id = $(wrapper).attr('id');
        self.component_id = $(wrapper).attr('component_id');
        self.component_namespace = $(wrapper).attr('component_namespace');
        self.component_index = $(wrapper).attr('component_index');
        self.loading_lang = $(wrapper).attr('loading_lang');
        self.loading_async = $(wrapper).attr('loading_async');
        initTooltipsForDatatables(self.wrapper_id);
        
        self.initAjaxCp();
    },
    methods: {
        initAjaxCp: function() {
            var self = this;
            if (self.loading_async) {
                mgDtAjaxCpWrappers.registerAjaxComponent(this);
            } else {
                self.loadAjaxData();
            }
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
                self.data = data.data.rawData;
                self.loading_state = false;
            });
        }
    }
});

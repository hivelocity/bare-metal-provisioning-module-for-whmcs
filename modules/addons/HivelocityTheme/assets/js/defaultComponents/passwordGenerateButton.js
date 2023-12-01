mgJsComponentHandler.addDefaultComponent('mg-pass-gen', {
    template: '#t-mg-pass-gen',
    props: [
        'component_id',
        'component_namespace',
        'component_index',
        'component_default_p'
    ],
    data : function() {
        return {
            password: null
        }
    },
    mounted: function () {
        var self = this;
        self.password = self.component_default_p;
    },
    methods: {
        generatePass: function() {
            var self = this;
            self.password = mgPageControler.vueLoader.rendKey(10);
        }
    }
});

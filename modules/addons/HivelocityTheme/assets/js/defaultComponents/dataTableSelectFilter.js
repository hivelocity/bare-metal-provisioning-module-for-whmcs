mgJsComponentHandler.addDefaultComponent('mg-dt-select-filter', {
    template : '#t-mg-dt-select-filter',
    props: [
        'component_id',
        'component_namespace',
        'component_index',
        'parent_id',
    ],
    data : function() {
        return {
            options: [],
            selected: null,
            selectInstance: null
        };
    },
    created: function () {
        var self = this;

        self.$nextTick(function() {
            self.initSelect();
        });
    },
    methods: {
        initSelect: function() {
            var self = this;

            var selSelect = $('#' + self.component_id).selectize({});

            self.selectInstance  = selSelect[0].selectize;
            self.selectInstance.on('change', function(value){
                self.$store.commit('updateComponentData', {componentName: self.parent_id, optionName: self.component_id,
                    optionGroup: 'filters', optionValue: value});
                self.selectChangeAction();
            });

            self.$store.commit('updateComponentData', {componentName: self.parent_id, optionName: self.component_id,
                    optionGroup: 'filters', optionValue: self.selectInstance.getValue()});
        },
        selectChangeAction : function() {
            mgEventHandler.runCallback('SelectFieldValueChanged', this.component_id, {data: this});
        },
    }
});

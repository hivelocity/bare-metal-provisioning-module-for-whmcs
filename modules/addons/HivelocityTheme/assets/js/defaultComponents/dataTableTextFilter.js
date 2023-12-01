mgJsComponentHandler.addDefaultComponent('mg-dt-text-filter', {
    template : '#t-mg-dt-text-filter',
    props: [
        'component_id',
        'component_namespace',
        'component_index',
        'parent_id',
        'required_to_search',
        'filter_value'
    ],
    data : function() {
        return {
            filterValue: null
        };
    },
    created: function () {
        this.initComponent();
    },
    methods: {
        initComponent: function() {
            this.filterValue = this.filter_value;
            if (this.required_to_search)
            {
                this.$store.commit('updateComponentData', {componentName: this.parent_id, optionName: this.component_id,
                     optionGroup: 'requiredFilters', optionValue: (this.isValueValid() ? false : true)});
            }

            this.$store.commit('updateComponentData', {componentName: this.parent_id, optionName: this.component_id,
                    optionGroup: 'filters', optionValue: this.filterValue});
        },
        updateFilterValue: function(event) {
            this.filterValue = event.target.value;
            this.$store.commit('updateComponentData', {componentName: this.parent_id, optionName: this.component_id,
                optionGroup: 'filters', optionValue: this.filterValue});

            if (this.required_to_search)
            {
                this.$store.commit('updateComponentData', {componentName: this.parent_id, optionName: this.component_id,
                    optionGroup: 'requiredFilters', optionValue: (this.isValueValid() ? false : true)});
            }
            this.$nextTick(function(){
                mgEventHandler.runCallback('DatatableFilterUpdated', this.parent_id, {data: this});
            });
        },
        isValueValid: function(){
            if ($.trim(this.filterValue) !== '') {
                return true;
            } else {
                return false;
            }
        }
    }
});

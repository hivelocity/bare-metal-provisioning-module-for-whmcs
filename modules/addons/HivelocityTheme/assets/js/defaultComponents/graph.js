mgJsComponentHandler.addDefaultComponent('mg-graph', {   
    template : '#t-mg-graph',
    props: [
        'component_id',
        'component_namespace',
        'component_index',
        'settings_key'
    ],
    data : function () {
        return {
            loading : false,
            chart: null,
            type: '',
            isRestart : false,
            data: {},
            parseData: "{}",
            options: {},
            filter: {},
            parseFilter: "{}",
        };
    },
    created: function () {
        var self = this;
        self.updateProjects();
        self.$parent.$root.$on('reloadMgData', self.updateMgData);
    },
    mounted: function () {
        var self = this;
    },
    methods: {
        updateMgData: function(toReloadId){
            var self = this;
            if (("graph_" + self.component_id) === toReloadId && !self.settings_key) {
                self.updateProjects();
                self.$nextTick(function() {
                    self.$emit('restartRefreshingState');
                });
            }
            else if (("graph_rl_" + self.settings_key) === toReloadId && self.settings_key) {
                self.updateProjects();
                self.$nextTick(function () {
                    self.$emit('restartRefreshingState');
                });
            }
            else if (("graph_" + self.component_id) === toReloadId && self.settings_key && toReloadId !== "graph_rl_" + self.settings_key) {
                mgPageControler.vueLoader.runRefreshActions(["graph_rl_" + self.settings_key]);
            }
        },
        createChart: function () {
            var self = this;
            if (self.chart == null || self.isRestart === true) {
               self.$nextTick(function() {
                    self.isRestart = false;
                    var ctx = document.getElementById('canv_' + self.component_id);
                    self.fixDataStructure();
                    self.$nextTick(function() {
                        self.chart = new Chart(ctx, {
                            type: self.type,
                            data: {
                                datasets: self.data.datasets,
                            },
                            options: self.options
                        });
                        self.reloadChart();
                    });  
                });  
            }
        },
        updateProjects: function () {
            var self = this;
            self.loading = true;
            var request = this.$parent.$root.$options.methods.vloadData({loadData : self.component_id, namespace : self.component_namespace, index: self.component_index}, true);
            request.done(function(data)
            {
                data = JSON.parse(data);
                
                if (data.data && data.data.rawData) {
                    data = data.data.rawData;
                    if (data.type) {
                        self.type = data.type;
                    }
                    if (data.data) {
                        self.parseData = JSON.stringify(data.dataParse);
                        self.data = data.data;
                    }
                    if (data.options) {
                        self.options = data.options;
                    }
                    if (data.filter) {
                        self.filter = data.filter;
                        self.parseFilter = JSON.stringify(data.filter);
                    }
                }
                self.$nextTick(function() {
                    if (!self.chart) {
                        self.createChart();
                    } else {
                        self.reloadChart();
                    }
                    self.loading = false;
                });
            })
            .fail(function() {});
        },
        reloadChart: function () {
            var self = this;
            if (self.chart)
            {   
                self.fixDataStructure();
                self.chart.options = self.options;
                self.chart.data.datasets = self.data.datasets;

                self.chart.update();
            }
        },
        restartChart: function () {
            var self = this;
            self.isRestart = true;
            self.createChart();
        },                
        loadModal: function(event, targetId, namespace, index, params, addSpinner){
            var self = this;
            var params = [];
            params.push({name: 'customParams', value: self.parseData});
            params.push({name: 'defaultFilter', value: self.parseFilter});
            mgPageControler.vueLoader.loadModal(event, targetId, typeof namespace !== 'undefined' ? namespace : getItemNamespace(targetId), index, params, addSpinner);
        },
        onOffSwitch: function(event, targetId){
            var switchPostData = $(event.target).is(':checked') ? {'value' : 'on'} : {'value' : 'off'};
            mgPageControler.vueLoader.ajaxAction(event, targetId, getItemNamespace(targetId), getItemIndex(targetId), switchPostData);                  
        },   
        makeCustomAction : function(functionName, params, event, namespace, index) {
            mgPageControler.vueLoader.makeCustomAction(functionName, params, event, namespace, index);
        },             
        redirect :  function (event, params) {
            mgPageControler.vueLoader.redirect(event, params);
        },
        //TODO: refactor this function to a recuring crowler
        fixDataStructure: function () {
            var self = this;
            
            var varsToBeConverted = ['backgroundColor', 'borderColor', 'data', 'hoverBackgroundColor',
                'hoverBorderColor', 'pointBackgroundColor', 'pointBorderColor', 'pointHoverBackgroundColor', 'pointHoverBorderColor'];
            
            for (var key in self.data.datasets) {
                if (!self.data.datasets.hasOwnProperty(key)) {
                    continue;
                }

                var tmpObj = self.data.datasets[key];
                for (var convKey in varsToBeConverted)
                {
                    if (typeof tmpObj[varsToBeConverted[convKey]] === 'object')
                    {
                        self.data.datasets[key][varsToBeConverted[convKey]] = Object.values(tmpObj[varsToBeConverted[convKey]]);
                    }
                    else if(typeof tmpObj[varsToBeConverted[convKey]] !== 'undefined') {
                        self.data.datasets[key][varsToBeConverted[convKey]] = tmpObj[varsToBeConverted[convKey]];
                    }
                    else {
                        //do nothing
                    }
                }
            }
            if (typeof self.data.labels !== 'undefined')
            {
                self.options.labels = Object.values(self.data.labels);
            }
            if (typeof self.options.scales !== 'undefined' && typeof self.options.scales.xAxes !== 'undefined')
            {
                self.options.scales.xAxes[0].labels = Object.values(self.data.labels);
            }
            if (typeof self.options.scales !== 'undefined' && typeof self.options.scales.xAxes !== 'undefined' && typeof self.options.scales.xAxes[0] !== 'undefined'
                    && typeof self.options.scales.xAxes[0].ticks !== 'undefined' && typeof self.options.scales.xAxes[0].ticks.callback !== 'undefined')
            {
                if (typeof self.options.scales.xAxes[0].ticks.callbackFN === 'undefined'){
                    self.options.scales.xAxes[0].ticks.callbackFN = self.options.scales.xAxes[0].ticks.callback;
                }

                var tmpCallbackName = self.options.scales.xAxes[0].ticks.callbackFN;
                var tmpCallbackFunction = window[tmpCallbackName];

                self.options.scales.xAxes[0].ticks.callback = tmpCallbackFunction;
            }

            if (typeof self.options.scales !== 'undefined' && typeof self.options.scales.yAxes !== 'undefined' && typeof self.options.scales.yAxes[0] !== 'undefined'
                    && typeof self.options.scales.yAxes[0].ticks !== 'undefined' && typeof self.options.scales.yAxes[0].ticks.callback !== 'undefined')
            {
                if (typeof self.options.scales.yAxes[0].ticks.callbackFN === 'undefined'){
                    self.options.scales.yAxes[0].ticks.callbackFN = self.options.scales.yAxes[0].ticks.callback;
                }

                var tmpCallbackName = self.options.scales.yAxes[0].ticks.callbackFN;
                var tmpCallbackFunction = window[tmpCallbackName];

                self.options.scales.yAxes[0].ticks.callback = tmpCallbackFunction;
            }

            if (typeof self.options.tooltips !== 'undefined' && typeof self.options.tooltips.callbacks !== 'undefined'
                    && typeof self.options.tooltips.callbacks.label !== 'undefined')
            {
                if (typeof self.options.tooltips.callbacks.labelCallbackFN === 'undefined'){
                    self.options.tooltips.callbacks.labelCallbackFN = self.options.tooltips.callbacks.label;
                }

                var tmpCallbackName = self.options.tooltips.callbacks.labelCallbackFN;
                var tmpCallbackFunction = window[tmpCallbackName];

                self.options.tooltips.callbacks.label = tmpCallbackFunction;
            }
        }
    }
});

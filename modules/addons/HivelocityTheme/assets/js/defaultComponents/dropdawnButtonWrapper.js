mgJsComponentHandler.addDefaultComponent('mg-dropdawn-btn-wrapper', {
    template : '#t-mg-dropdawn-btn-wrapper',
    props: [
        'component_id',
        'component_namespace',
        'component_index'
    ],
    data : function() {
        return {
            dropOpen: false
        };
    },
    created: function () {
    },
    methods: {
        toogleDropdawn: function(event) {
            var self = this;
            self.dropOpen = !self.dropOpen;
        },
        hideDrop :function(event){
            var self = this;
            self.dropOpen = false;
            self.$nextTick(function() {
                var clickedEl = document.elementFromPoint(event.clientX, event.clientY);
                if (!$(clickedEl).hasClass('mg-drop-target-btn') && $(clickedEl).parents('.mg-drop-target-btn').length === 0) {
                    $(clickedEl).click();
                }
            });
        },
        notHideDrop: function(event){
            event.preventDefault();
            event.stopPropagation();
            var self = this;
            self.dropOpen = true;            
        },
        loadModal: function(event, targetId, namespace, index){
            mgPageControler.vueLoader.loadModal(event, targetId,
                typeof namespace !== 'undefined' ? namespace : getItemNamespace(targetId),
                typeof index !== 'undefined' ? index : getItemIndex(targetId));
        },
        makeCustomAction : function(functionName, params, event, namespace, index) {
            mgPageControler.vueLoader.makeCustomAction(functionName, params, event, namespace, index);
        },        
        redirect :  function (event, params, targetBlank) {
            mgPageControler.vueLoader.redirect(event, params, targetBlank);
        }
    }
});

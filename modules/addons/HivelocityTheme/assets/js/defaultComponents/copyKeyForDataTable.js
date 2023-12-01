mgJsComponentHandler.addDefaultComponent('ds-copy-on-click', {
    template: '#t-ds-copy-on-click',
    data: function () {
        return {
            wrapper_id: null,
            text_to_copy: null,
            confirmation_lang: null
        };
    },
    mounted: function () {
        var self = this;
        var wrapper = $(self.$el).parent();
        self.wrapper_id = $(wrapper).attr('id');
        self.component_id = $(wrapper).attr('component_id');
        self.text_to_copy = $(wrapper).attr('text_to_copy');
        self.confirmation_lang = $(wrapper).attr('confirmation_lang');
        initTooltipsForDatatables(self.wrapper_id);
    },
    methods: {
        copyTextToClipboard: function() {
            var self = this;
            initTooltipsForDatatables(self.wrapper_id);
            var copyText = document.getElementById("cp_txt_" + self.component_id);
            copyText.select();
            document.execCommand("copy");
            mgPageControler.vueLoader.addAlert('success', self.confirmation_lang);
        }
    }
});

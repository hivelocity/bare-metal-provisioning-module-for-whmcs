mgJsComponentHandler.addDefaultComponent('mg-passtoogle', {
    template: '#t-mg-passtoogle',
    data: function () {
        return {
            wrapper_id: null,
            text_to_copy: null,
            confirmation_lang: null,
            passwordShow: false
        };
    },
    mounted: function () {
        var self = this;
        var wrapper = $(self.$el).parent();
        self.wrapper_id = $(wrapper).attr('id');
        self.component_id = $(wrapper).attr('component_id');
        self.text_to_copy = $(wrapper).attr('text_to_copy');
        self.confirmation_lang = $(wrapper).attr('confirmation_lang');
    },
    methods: {

    }
});

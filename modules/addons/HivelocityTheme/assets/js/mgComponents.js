function getItemNamespace (elId) {
    return jQuery('#' + elId).attr('namespace');
}

function getItemIndex (elId) {
    return jQuery('#' + elId).attr('index');
}

function initMassActionsOnDatatables(elId){
    $('#' + elId + ' [data-check-container]').luCheckAll({
        onCheck: function(container, counter) {
            var massActions = container.find('.lu-t-c__mass-actions');
            massActions.find('.lu-value').html(counter);
            if (counter > 0) {
                massActions.addClass('is-open');
            } else {
                massActions.removeClass('is-open');
            }
        }
    });
}

function collectTableMassActionsData(elId){
    var colectedData = {};
    $('#' + elId + ' [data-check-container] tbody input:checkbox.table-mass-action-check:enabled:checked')
        .each(function(index, value){
            colectedData[index] = $(this).val();
    });

    return colectedData;
}

function uncheckSelectAllCheck(elId){
    closeAllSelectMassActions();
}

function closeAllSelectMassActions(){
    $('.lu-t-c__mass-actions').removeClass('is-open');
    $('.table-mass-action-check').prop('checked', false);
    $('thead input:checkbox:enabled').prop('checked', false);
}

function initTooltipsForDatatables(elId) {
    $('#' + elId + ' [data-toggle="lu-tooltip"], [data-tooltip]').luTooltip({});    
}

function initModalSelects(){
    initContainerSelects('mgModalContainer');
}
function initContainerSelects(id) {
    $('#' + id + ' select:not(.ajax)').each(function(){
        if ($(this).attr('bi-event-change')) {
            var biEventAction = $(this).attr('bi-event-change');
            $(this).selectize({
                plugins: ['remove_button'],
                onItemAdd : function(value){
                    if (biEventAction === 'initReloadModal') {
                        mgPageControler.modalInstance.initReloadModal();
                    }
                    else if (biEventAction && typeof mgPageControler[biEventAction] === "function") {
                        setTimeout(function(){
                            mgPageControler[biEventAction]();
                        }, 500);
                    }
                    else if (biEventAction && typeof mgPageControler.vueLoader[biEventAction] === "function") {
                        setTimeout(function(){
                            mgPageControler.vueLoader[biEventAction]();
                        }, 500);
                    } else if (biEventAction && typeof window[biEventAction] === "function") {
                        setTimeout(function(){
                            window[biEventAction]();
                        }, 500);
                    }
                }
            });
        } else {
            $(this).luSelect({});
        }
    });
}

function initModalSwitchEvents(){
    $('#mgModalContainer :checkbox').each(function(){
        if ($(this).attr('bi-event-change')) {
            var biEventAction = $(this).attr('bi-event-change');
            $(this).change(function() {
                    if (biEventAction && typeof mgPageControler[biEventAction] === "function") {
                        setTimeout(function(){
                            mgPageControler[biEventAction]();
                        }, 500);
                    }
                    else if (biEventAction && typeof mgPageControler.vueLoader[biEventAction] === "function") {
                        setTimeout(function(){
                            mgPageControler.vueLoader[biEventAction]();
                        }, 500);
                    } else if (biEventAction && typeof window[biEventAction] === "function") {
                        setTimeout(function(){
                            window[biEventAction]();
                        }, 500);
                    }
            });
        }
    });
}

function initModalTooltips(){
    initContainerTooltips('mgModalContainer');
}

function initContainerTooltips(id) {
    $('#' + id + ' [data-toggle="lu-tooltip"], [data-tooltip]').luTooltip({});
}

function mgFormControler(targetFormId) {
    this.fields = null;
    this.data = {};
    this.formId = targetFormId;

    this.formElement = null;
    this.formDataObj = null;

    this.loadFormFields = function(){
        var that = this;

        jQuery('#'+this.formId).find('input,select,textarea').each(function () {
            if (!jQuery(this).is(':disabled')) {
                var name = jQuery(this).attr('name');

                var value = null;

                if (name !== undefined) {
                    var type = jQuery(this).attr('type');
                    var regExp = /([a-zA-Z_0-9]+)\[([a-zA-Z_0-9]+)\]/g;
                    var regExpLg = /([a-zA-Z_0-9]+)\[([a-zA-Z_0-9]+)\]\[([a-zA-Z_0-9]+)\]/g;

                    if (type === 'checkbox') {
                        var value = 'off';
                        jQuery('#'+that.formId).find('input[name="'+name+'"]').each(function () {
                            if (jQuery(this).is(':checked')) {
                                value = jQuery(this).val();
                            }
                        });
                    } else if (type === 'radio') {
                        if (jQuery(this).is(':checked')) {
                            var value = jQuery(this).val();
                        }
                    } else if (type === 'file') {
                        var value ={
                            type: 'file',
                            value: jQuery(this).val()
                        };
                    } else {
                        var value = jQuery(this).val();
                    }
                    if (value !== null) {
                        if (result = regExpLg.exec(name)) {
                            if (that.data[result[1]] === undefined) {
                                that.data[result[1]] = {};
                            }
                            if (that.data[result[1]][result[2]] === undefined) {
                                that.data[result[1]][result[2]] = {};
                            }
                            that.data[result[1]][result[2]][result[3]] = value;
                        }else if (result = regExp.exec(name)) {
                            if (that.data[result[1]] === undefined) {
                                that.data[result[1]] = {};
                            }
                            that.data[result[1]][result[2]] = value;
                        } else {
                            that.data[name] = value;
                        }
                    }
                }
            }
        });
    };

    this.getFieldsData = function() {
        this.formElement = null;
        this.formDataObj = null;

        this.loadFormFields();

        var formatedData = new FormData();
        for (var key in this.data) {
            if (!this.data.hasOwnProperty(key)) {
                continue;
            }
            var KeyValue = this.data[key];
            if (key.indexOf('[') > 0){
                var formatedKey = 'formData[' + key.substring(0, key.indexOf('[')) + ']' + key.substring(key.indexOf('['));
            } else {
                var formatedKey = 'formData[' + key + ']'
            }

            if(typeof KeyValue === 'object') {
                if (KeyValue.type === 'file'){
                    this.addFieldData(formatedData, key, formatedKey, KeyValue);
                } else{
                    this.addIteratedData(formatedData, formatedKey, KeyValue);
                }
            } else {
                formatedData.set(formatedKey, KeyValue);
            }
        }

        return formatedData;
    };

    this.addFieldData = function(formatedData, key, formatedKey, KeyValue){
        if (!this.formElement) {
            this.formElement = document.querySelector("#" + this.formId);
            this.formDataObj = new FormData(this.formElement);
        }

        KeyValue = this.formDataObj.get(key);
        if (typeof KeyValue !== 'object') {
            formatedData.set(formatedKey, KeyValue);
        } else {
            formatedData.set(formatedKey, KeyValue, KeyValue.name);
        }
    };

    this.addIteratedData = function(formatedData, formatedKey, KeyValue){
        for (var key in KeyValue) {
            if (!KeyValue.hasOwnProperty(key)) {
                continue;
            }
            if (typeof KeyValue[key] === 'object') {
                this.addIteratedData(formatedData, formatedKey + '[' + key + ']', KeyValue[key]);
            } else {
                formatedData.set(formatedKey + '[' + key + ']', KeyValue[key]);
            }
        }
    };

    this.updateFieldsValidationMessages = function(errorsList) {
        jQuery('#'+this.formId).find('input,select,textarea').each(function () {
            if (!jQuery(this).is(':disabled')) {
                var name = jQuery(this).attr('name');
                if(name !== undefined && errorsList[name] !== undefined)
                {
                    if(!jQuery(this).parents('.lu-form-group').first().hasClass('lu-is-error')) {
                        jQuery(this).parents('.lu-form-group').first().addClass('lu-is-error');
                    }
                    
                    var messagePlaceholder = jQuery(this).parents('.lu-form-group').first().children('.lu-form-feedback');
                    if(jQuery(messagePlaceholder).length > 0)
                    {    
                        jQuery(messagePlaceholder).html(errorsList[name].slice(-1)[0]);
                        if(jQuery(messagePlaceholder).attr('hidden')){
                            jQuery(messagePlaceholder).removeAttr('hidden');
                        }
                    }
                }else if(name !== undefined) {
                    if(jQuery(this).parents('.lu-form-group').first().hasClass('lu-is-error')) {
                        jQuery(this).parents('.lu-form-group').first().removeClass('lu-is-error');
                    }
                    var messagePlaceholder = jQuery(this).parents('.lu-form-group').first().children('.lu-form-feedback');
                    if(jQuery(messagePlaceholder).length > 0){
                        jQuery(messagePlaceholder).html('');
                        if(!jQuery(messagePlaceholder).attr('hidden')){
                            jQuery(messagePlaceholder).attr('hidden', 'hidden');
                        }                        
                    }
                }
            }
        });
    };
};

//Sortable
function tldCategoriesSortableController()
{
    var helperHeight = 0;

    //Add sortable for parent categories
    if (! $('#groupList.vSortable').hasClass('ui-sortable'))
    {
        $("#groupList.vSortable").sortable(
        {
            items: "li:not(.lu-nav--sub li, .sortable-disabled)",
            start: function(event, ui)
            {
                $(ui.item).find("ul").hide();
                $("#groupList").attr("isBeingSorted", "true");
            },
            stop: function(event, ui)
            {
                var order = [];
                $("#groupList .nav__item").each(function(index, element)
                {
                    if($(element).hasClass("ui-sortable-placeholder"))
                    {
                        return;
                    }

                    var catId = $(element).attr("actionid");
                    order.push(catId);
                });

                mgPageControler.vueLoader.updateSorting(order, 'addCategoryForm', 'ModulesGarden_Virusdie_App_UI_Widget_DoeTldConfigComponents_CategoryForms_AddCategoryForm');
                $(ui.item).css("height", helperHeight);
                $(ui.item).find("a").css("height", 32);
                $(ui.item).find("ul").show();
            },
            sort: function(event, ui)
            {
                $( "#groupList" ).sortable( "refreshPositions" );
            },
            helper: function(event, li)
            {
                helperHeight = $(li).css("height");
                $(li).css("height", 32);
                return li;
            },
        });
    }

    //Add sortable for children - this has to be refreshed per catego content load
    $("#groupList.vSortable .nav--sub").sortable(
    {
        stop: function(event, ui)
        {
            var order = [];
            $(this).find(".nav__item").each(function(index, element)
            {
                if($(element).hasClass("ui-sortable-placeholder"))
                {
                    return;
                }

                var catId = $(element).attr("actionid");
                order.push(catId);
            });

            mgPageControler.vueLoader.updateSorting(order, 'addCategoryForm', 'ModulesGarden_Virusdie_App_UI_Widget_DoeTldConfigComponents_CategoryForms_AddCategoryForm');
        },
    });

    //Add Sortable on table
    $('#itemContentContainer tbody.vSortable').sortable(
    {
        stop: function(event, ui)
        {
            var order = [];
            $("#itemContentContainer tbody").find("tr").each(function(index, element)
            {
                if($(element).hasClass("ui-sortable-placeholder"))
                {
                    return;
                }

                var catId = $(element).attr("actionid");
                order.push(catId);
            });
            mgPageControler.vueLoader.updateSorting(order, 'assignTldForm', 'ModulesGarden_Virusdie_App_UI_Widget_DoeTldConfigComponents_CategoryForms_AssignTldForm');
        },
        helper: function(e, tr)
        {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function(index)
            {
                $(this).width($originals.eq(index).width()+100);
            });

            return $helper;
        },
    });

}


// CUSTOM FUNCTIONS

//this is example custom action, use it for non-ajax actions
function custAction1(vueControler, params, event){
    console.log('custAction1', vueControler, params, event);
}

//this is example custom action, use it for ajax actions
function custAction2(vueControler, params, event){
    console.log('custAction2', vueControler, params, event);
}

function mgEmptyToPause(name, row) {
    if (!row[name] || row[name] === '') {
        return '-';
    }
    else {
        return row[name];
    }
}

function newCall(data) {
    console.log(data);
}

function buildOptionTag(text, value, selected, disabled) {
    var option = document.createElement("option");
    option.text = text;
    option.value = value;
    if (selected) {
        option.setAttribute('selected', 'selected');
    }
    if (disabled) {
        option.setAttribute('disabled', 'disabled');
    }
    
    return option;
}

function initTaggersForContainer(containerId){
    jQuery('#' + containerId + ' .lu-tagger').each(function()
    {
        if(!jQuery(this).hasClass('selectize-input'))
        {
            $(this).selectize({
                plugins: ['restore_on_backspace'],
                delimiter: ',',
                persist: false,
                create: function(input) {
                    return {
                        value: input,
                        text: input
                    }
                }
            });
        }
    });
}

function initModalTaggers() {
    initTaggersForContainer('mgModalContainer');
}

function initAppTaggers() {
    initTaggersForContainer('layers');
}

mgEventHandler.on('AppCreated', null, function(id, params){
    setTimeout(function() {
        initAppTaggers();
        }, 100);
}, 900);

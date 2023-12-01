                    </div>
                </div>
            </div>
        <div class="clear"></div>
    </div>


    <script type="text/javascript" src="{$domain}/modules/addons/HivelocityTheme/assets/js/vue.min.js"></script>
    <script type="text/javascript" src="{$domain}/modules/addons/HivelocityTheme/assets/js/vuex.min.js"></script>
    <script type="text/javascript" src="{$domain}/modules/addons/HivelocityTheme/assets/js/moment.js"></script>
    <script type="text/javascript" src="{$domain}/modules/addons/HivelocityTheme/assets/js/mgComponents.js"></script>
    <script type="text/javascript" src="{$domain}/modules/addons/HivelocityTheme/assets/js/jscolor.min.js"></script>
    <script type="text/javascript" src="{$domain}/modules/addons/HivelocityTheme/assets/js/layers-ui.js"></script>
    <script type="text/javascript" src="{$domain}/modules/addons/HivelocityTheme/assets/js/layers-ui-table.js"></script>    
    <script type="text/javascript" src="{$domain}/modules/addons/HivelocityTheme/assets/js/chart.min.js"></script>
    <script type="text/javascript" src="/assets/js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
        var tinymceSettings = {
            selector: "textarea.tinymce",
            height: 500,
            theme: "modern",
            entity_encoding: "raw",
            plugins: "autosave print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template code codesample table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists textcolor wordcount contextmenu colorpicker textpattern help paste",
            toolbar: [
                "formatselect,fontselect,fontsizeselect,|,bold,italic,strikethrough,underline,forecolor,backcolor,|,link,unlink,|,justifyleft,justifycenter,justifyright,justifyfull,|,search,replace,|,bullist,numlist,",
                "outdent,indent,blockquote,|,undo,redo,|,cut,copy,paste,pastetext,pasteword,|,table,|,hr,|,sub,sup,|,charmap,image,media,|,print,|,ltr,rtl,|,fullscreen,|,help,code,removeformat"
            ],
            image_advtab: true,
            content_css: [
                "//fonts.googleapis.com/css?family=Lato:300,300i,400,400i",
                "//www.tinymce.com/css/codepen.min.css"
            ],
            browser_spellcheck: true,
            convert_urls : false,
            relative_urls : false,
            forced_root_block : "p",
            media_poster: false,
            mobile: {
                theme: "mobile",
                plugins: ["autosave", "lists", "autolink"],
                toolbar: ["undo", "bold", "italic", "styleselect"]
            },
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;

            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open("POST", "/admin/image/upload/em");

            xhr.onload = function() {
                var json;

                if (xhr.status != 200) {
                    failure("HTTP Error: " + xhr.status + " - " + xhr.responseText);
                    return;
                }

                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != "string") {
                    failure("Invalid JSON: " + xhr.responseText);
                    return;
                }

                success(json.location);
            };

            formData = new FormData();
            formData.append("token", csrfToken);
            formData.append("file", blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        },
        automatic_uploads: true,
        file_browser_callback_types: "image",
        images_reuse_filename: true,
        image_list: "/admin/image/recent/em"

        };

        $(document).ready(function() {
            tinymce.init(tinymceSettings).then(function(editors){
                editorLoaded = true;
                tinymce.addI18n("image", {
                    "Image list": "Recent images"
                });
            });
        });

        var editorEnabled = true,
            editorLoaded = false;

        function toggleEditor() {
            if (editorEnabled === true) {
                tinymce.activeEditor.remove();
                editorEnabled = false;
            } else {
                tinymce.init(tinymceSettings);
                editorEnabled = true;
            }
        }

        function insertMergeField(mfield) {
            tinymce.activeEditor.insertContent("[$" + mfield + "]");
        }

</script>
export default {
    data() {
        return {
            plugins: [
                'advlist autolink anchor code codesample',
                'lists link searchreplace fullscreen',
                'insertdatetime image media table paste help wordcount',
                "hr visualchars nonbreaking textpattern",
                'imagetools noneditable'
            ],
            toolbar: 'bold italic underline strikethrough | fontsizeselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist table | insertfile image media link instagram | forecolor backcolor removeformat | code fullscreen',
        };
    },

    methods: {
        tinymceInit() {
            let editor_id = "";

            let dialogConfig = {
                title: 'Embed Instagram',

                body: {
                    type: 'panel',
                    items: [
                        {
                            type: 'input',
                            name: 'instagram',
                            label: 'enter embed code from instagram'
                        }
                    ]
                },

                buttons: [
                    {
                        type: 'cancel',
                        name: 'closeButton',
                        text: 'Cancel'
                    },
                    {
                        type: 'submit',
                        name: 'submitButton',
                        text: 'Submit',
                        primary: true
                    }
                ],

                initialData: {
                    instagram: '',
                },

                onSubmit: function (api) {
                    var data = api.getData();

                    var embedCode = data.instagram;

                    if (embedCode && embedCode.includes("script")) {
                        var script = embedCode.match(/<script.*<\/script>/)[0];
                        var scriptSrc = script.match(/".*\.js/)[0].split("\"")[1];

                        // <script async defer src="//www.instagram.com/embed.js"></script>
                        var sc = document.createElement("script");
                        sc.setAttribute("src", scriptSrc);
                        sc.setAttribute("type", "text/javascript");

                        var iframe = document.getElementById(editor_id + "_ifr");
                        var iframeHead = iframe.contentWindow.document.getElementsByTagName('head')[0];

                        iframeHead.appendChild(sc);
                        setTimeout(function () {
                            iframe.contentWindow.instgrm.Embeds.process();
                        }, 1000)
                    }

                    tinyMCE.activeEditor.insertContent(`${data.instagram}`);

                    api.close();
                }
            };

            return {
                plugins: this.plugins,
                toolbar: this.toolbar,
                image_advtab: true,
                image_caption: true,
                menubar: false,
                toolbar_drawer: 'floating',
                paste_data_images: true,
                content_style: "p { margin: 0; }",
                automatic_uploads: false,
                relative_urls: false,
                remove_script_host: false,
                setup: function (editor) {
                    editor.on('init', function (args) {
                        editor_id = args.target.id;
                    });

                    editor.ui.registry.addButton('instagram', {
                        text: 'Instagram',
                        onAction: function () {
                            editor.windowManager.open(dialogConfig)
                        }
                    });
                },
                file_picker_callback(callback, value, meta) {
                    let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
                    let y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight

                    tinymce.activeEditor.windowManager.openUrl({
                        url: '/file-manager/tinymce5',
                        title: 'File manager',
                        width: x * 0.8,
                        height: y * 0.8,
                        onMessage: (api, message) => {
                            callback(message.content, { text: message.text })
                        }
                    })
                }
            }
        },
    }
};
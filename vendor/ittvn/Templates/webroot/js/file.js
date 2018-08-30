// Create Base64 Object
var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}};

$(document).ready(function () {

    $(window).resize(function () {
        var h = Math.max($(window).height() - 0, 420);
        $('#container, #data, #tree, #data .content').height(h).filter('.default').css('lineHeight', h + 'px');
    }).resize();

    var editor = '';
    $('#galleries')
            .jstree({
                core: {
                    data: {
                        url: ittvn.config.base_url + 'admin/medias/filemanage/index/list',
                        data: function (node) {
                            //alert(node.id);
                            return {'id': node.id};
                        },
                        dataType: 'json',
                        contentType: 'application/json charset=utf-8',
                    },
                    'check_callback': function (o, n, p, i, m) {
                        if (m && m.dnd && m.pos !== 'i') {
                            return false;
                        }
                        if (o === "move_node" || o === "copy_node") {
                            if (this.get_node(n).parent === this.get_node(p).id) {
                                return false;
                            }
                        }
                        return true;
                    },
                    'themes': {
                        'responsive': false,
                        'variant': 'small',
                        'stripes': true
                    }
                },
                'sort': function (a, b) {
                    return this.get_type(a) === this.get_type(b) ? (this.get_text(a) > this.get_text(b) ? 1 : -1) : (this.get_type(a) >= this.get_type(b) ? 1 : -1);
                },
                'contextmenu': {
                    'items': function (node) {
                        var tmp = $.jstree.defaults.contextmenu.items();
                        return false;
                    }
                },
                'types': {
                    'default': {'icon': 'folder'},
                    'file': {'valid_children': [], 'icon': 'file'}
                },
                'unique': {
                    'duplicate': function (name, counter) {
                        return name + ' ' + counter;
                    }
                },
                'plugins': ['state', 'dnd', 'sort', 'types', 'contextmenu', 'unique']
            })
            /*
            .on('delete_node.jstree', function (e, data) {
                var id = data.node.id;
                $.post(ittvn.config.base_url + 'admin/medias/galleries/delete/' + id, {})
                        .fail(function () {
                            data.instance.refresh();
                        });
            })
            .on('create_node.jstree', function (e, data) {
                var type = data.node.type;
                var parent_id = data.node.parent == 'j1_1' ? '' : data.node.parent;
                var name = data.node.text;
                $.post(ittvn.config.base_url + 'admin/medias/galleries/add', {name: name, parent_id: parent_id})
                        .done(function (d) {
                            data.instance.set_id(data.node, d.id);
                        })
                        .fail(function () {
                            data.instance.refresh();
                        });
            })
            .on('rename_node.jstree', function (e, data) {
                if (data.node.id == 'j1_1') {
                    data.instance.refresh();
                    return true;
                }

                var id = data.node.id == 'j1_1' ? '' : data.node.id;
                var name = data.text;
                $.post(ittvn.config.base_url + 'admin/medias/galleries/edit/' + id, {'id': id, name: name})
                        .done(function (d) {
                            data.instance.set_id(data.node, d.id);
                            //data.instance.refresh();
                        })
                        .fail(function () {
                            data.instance.refresh();
                        });
            })
            .on('move_node.jstree', function (e, data) {
                var id = data.node.id;
                var parent_id = data.parent;
                $.post(ittvn.config.base_url + 'admin/medias/galleries/move/' + id, {id: id, parent_id: parent_id})
                        .done(function (d) {
                            //data.instance.load_node(data.parent);
                            data.instance.refresh();
                        })
                        .fail(function () {
                            data.instance.refresh();
                        });
            })
            .on('copy_node.jstree', function (e, data) {
                var id = data.original.id;
                var parent_id = data.parent;
                $.post(ittvn.config.base_url + 'admin/medias/galleries/copy/' + id, {parent_id: parent_id})
                        .done(function (d) {
                            //data.instance.load_node(data.parent);
                            data.instance.refresh();
                        })
                        .fail(function () {
                            data.instance.refresh();
                        });
            })
            */
            .on('changed.jstree', function (e, data) {
                if (data && data.selected && data.selected.length) {
                    var gallery_id = 0;
                    if (data.selected.join(':') != 'j1_1') {
                        gallery_id = data.selected.join(':');
                    }
                    $('#file_manager .col-md-9 .row').prepend('<div class="sk-spinner sk-spinner-wave"><div class="sk-rect1"></div><div class="sk-rect2"></div><div class="sk-rect3"></div><div class="sk-rect4"></div><div class="sk-rect5"></div></div>');
                    $.get(ittvn.config.base_url + 'admin/medias/filemanage/view/' + gallery_id, function (d) {
                        if (d && typeof d.type !== 'undefined') {
                            $('#file_manager .col-md-9 .show_path .medias-path span').html(Base64.decode(gallery_id));
                            //$('#file_manager .col-lg-9 .col-lg-12').empty();
                            $('.box_code').hide();
                            switch (d.type) {
                                case 'text':
                                case 'txt':
                                case 'md':
                                case 'htaccess':
                                case 'editorconfig':
                                case 'gitattributes':
                                case 'gitignore':
                                case 'yml':
                                case 'json':
                                case 'log':
                                case 'sql':
                                case 'php':
                                case 'js':
                                case 'json':
                                case 'css':
                                case 'html':
                                case 'php':
                                case 'ctp':
                                    $('.box_code').show();
                                    $('#code').val(d.content);
                                    if ($('#code').next().hasClass('CodeMirror')) {
                                        $('#code').next().remove();
                                    }
                                    var mode = 'application/x-httpd-php';
                                    if(d.type=='js' || d.type=='json'){
                                        mode = 'javascript';
                                    }else if(d.type=='sql'){
                                        mode = 'text/x-mysql';
                                    }else if(d.type=='css'){
                                        mode = 'text/css';
                                    }
                                    editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                                        lineNumbers: true,
                                        matchBrackets: true,
                                        styleActiveLine: true,
                                        mode: mode,
                                        indentUnit: 4,
                                        indentWithTabs: true,
                                        extraKeys: {"Ctrl-Space": "autocomplete"},
                                    });
                                    break;
                                case 'png':
                                case 'jpg':
                                case 'jpeg':
                                case 'bmp':
                                case 'gif':
                                    $('#data .image img').one('load', function () {
                                        $(this).css({'marginTop': '-' + $(this).height() / 2 + 'px', 'marginLeft': '-' + $(this).width() / 2 + 'px'});
                                    }).attr('src', d.content);
                                    $('#data .image').show();
                                    break;
                                default:
                                    break;
                            }
                        }
                    }).done(function () {
                        $('#file_manager').parent().find('.sk-spinner').remove();
                    });
                }
                else {
                    $('#data .content').hide();
                    $('#data .default').html('Select a file from the tree.').show();
                }
            });

    $('.save_file_manage').click(function(){
        var r = confirm("Do you want save file?");
        if (r == true) {
            $.post(ittvn.config.base_url+'admin/medias/filemanage/save',{
                path:$('#file_manager .col-md-9 .show_path span').html(),
                content:editor.getValue()
            },function(){
                window.location.reload(true);
            });
        }     
    })

});
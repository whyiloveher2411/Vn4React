/**
 * plugin.js
 *
 * Copyright 2013 Web Power, www.webpower.nl
 * @author Arjan Haverkamp
 */

/*jshint unused:false */
/*global tinymce:true */

tinymce.PluginManager.requireLangPack('codemirror');

tinymce.PluginManager.add('codemirror', function(editor, url) {

	function showSourceEditor() {
        
        editor.focus();
        editor.selection.collapse(true);
        
        // Insert caret marker
        if (editor.settings.codemirror.saveCursorPosition) {
            editor.selection.setContent('<span style="display: none;" class="CmCaReT">&#x0;</span>');
        }

        codemirrorWidth = 800;
        if (editor.settings.codemirror.width) {
            codemirrorWidth = editor.settings.codemirror.width;
        }

        codemirrorHeight = 550;
        if (editor.settings.codemirror.width) {
            codemirrorHeight = editor.settings.codemirror.height;
        }
        
		var config = {
			title: 'HTML source code',
			url: url + '/source.html',
			width: codemirrorWidth,
			height: codemirrorHeight,
			resizable : true,
			maximizable : true,
			fullScreen: editor.settings.codemirror.fullscreen,
      saveCursorPosition: false,
			buttons: [
				{ text: 'Ok', type:'custom',name:'custom_ok', subtype: 'primary'},
				{ text: 'Cancel', onclick: 'close', type:'cancel' }
			],
			onAction:function(dialogApi, actionData){
				 if (actionData.name === 'custom_ok') {
				 	var doc = document.querySelectorAll('.tox-dialog__body-iframe iframe')[0];
					doc.contentWindow.submit();
					win.close();
				 }
			}
		};

		var win = editor.windowManager.openUrl(config);

		if (editor.settings.codemirror.fullscreen) {
			win.fullscreen(true);
		}
	};

	// Add a button to the button bar
	editor.ui.registry.addButton('code', {
		title: 'Source code',
		icon: 'code',
		onAction: showSourceEditor
	});

	// Add a menu item to the tools menu
	editor.ui.registry.addMenuItem('code', {
		icon: 'code',
		text: 'Source code',
		context: 'tools',
		onAction: showSourceEditor
	});
});

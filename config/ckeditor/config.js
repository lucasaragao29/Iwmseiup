/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	 config.language = 'pt-br';
	 config.uiColor = '#cccccc';
	config.toolbarCanCollapse = false
	
	//config.extraPlugins = 'widget';
	
 config.filebrowserBrowseUrl = 'http://imw6ti.acampamentoefraim.com.br/sei/config/ckeditor/kcfinder/browse.php?opener=ckeditor&type=files';
 config.filebrowserImageBrowseUrl = 'http://imw6ti.acampamentoefraim.com.br/sei/config/ckeditor/kcfinder/browse.php?opener=ckeditor&type=images';
 config.filebrowserFlashBrowseUrl = 'http://imw6ti.acampamentoefraim.com.br/sei/config/ckeditor/kcfinder/browse.php?opener=ckeditor&type=flash';
 config.filebrowserUploadUrl = 'http://imw6ti.acampamentoefraim.com.br/sei/config/ckeditor/kcfinder/upload.php?opener=ckeditor&type=files';
 config.filebrowserImageUploadUrl = 'http://imw6ti.acampamentoefraim.com.br/sei/config/ckeditor/kcfinder/upload.php?opener=ckeditor&type=images';
 config.filebrowserFlashUploadUrl = 'http://imw6ti.acampamentoefraim.com.br/sei/config/ckeditor/kcfinder/upload.php?opener=ckeditor&type=flash';
	
	CKEDITOR.editorConfig = function( config ) {
	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		'/',
		'/',
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];

	config.removeButtons = 'Save,NewPage,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Styles,Format,About,Flash';
};

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	//config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;h4;h5;h6;pre';

	// Simplify the dialog windows.
	//config.removeDialogTabs = 'image:advanced;link:advanced';
	
};

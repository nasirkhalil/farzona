/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	//config.extraPlugins = 'filebrowser';
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.allowedContent = true;
	var path12=CKEDITOR.basePath;
	config.extraPlugins = 'youtube';
   config.filebrowserBrowseUrl = path12+ 'image/browse.php?type=files';
   config.filebrowserImageBrowseUrl = path12+'image/browse.php?type=images';
   config.filebrowserFlashBrowseUrl = path12+'image/browse.php?type=flash';
   config.filebrowserUploadUrl = path12+'image/upload.php?type=files';
   config.filebrowserImageUploadUrl = path12+'image/upload.php?type=images';
   config.filebrowserFlashUploadUrl = path12+'image/upload.php?type=flash';
};

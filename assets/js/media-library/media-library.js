/*
 * Media Library
 *
 * Author: Estyr@mediaotg.com
 * Date: Feb 15, 17
 */

function mediaLibrary(element, root, single){

	var PLUGINLOCATION = '';
	getPluginLocation();

	// call with or without arguments
	if (root == null){
		root = 'uploads';
	}
	if (element == null){
		element = '.media-library';
	}
	if (single == null){
		single = true;
	}

	var selectedFiles = [];
	var thisElement = '';

	createModal();
	hideMediaModal();

	// create Media Library modal
	function createModal(){
		// create Modal
		$('body').append('<div class="media-library-wrapper"><div class="modal-media-library"></div></div>');

		fetchContents(root);
	}

	function updateModal(folders, files, dir, prevFolder){
		// clear modal
		// clear modal
		$('.modal-media-library').empty();
		$('.modal-media-library').append('<div class="inner_wrapper"></div>');
		modal = $('.modal-media-library .inner_wrapper');

		// add x
		$('.modal-media-library').prepend('<a href="#" class="close-button" id="close-media-modal">X</a>');

		// Add files
		if(files.length > 0){
			modal.append('<h5>Files</h5>');
		}
		var files = $.map(files, function(value, index) {
		    return [value];
		});
		for(i=0; i<files.length; i++){
			if((/\.jpe?g$/i.test(files[i])) || (/\.png$/i.test(files[i])) || (/\.gif$/i.test(files[i])) || (/\.svg$/i.test(files[i])) ){
				modal.append('<div class="media-library-item library-item file-item" data-path="'+dir+'/'+files[i]+'"><img src="'+dir+'/'+files[i]+'" /><p>' + files[i] + '</p></div>');
			} else {
				modal.append('<div class="media-library-item library-item file-item" data-path="'+dir+'/'+files[i]+'"><img src="assets/js/media-library/img/file.png" /><p>' + files[i] + '</p></div>');
			}
		}

		// Buttons
		$('.modal-media-library').append('<div class="actions"></div>');
		btns = $('.modal-media-library .actions');
		btns.append('<a href="" class="btn delete" id="delete-file" data-folder="'+prevFolder+'">Delete</a>');
		btns.append('<input type="file" id="media-file-upload" data-folder="'+prevFolder+'"></input><a href="" class="btn add" id="add-file">Add</a>');
		btns.append('<a href="" class="btn select" id="select-file">Select</a>');

		// Handle Events
		handleEvents();
	}

	// Event handler
	function handleEvents(){
		$('.folder-item').click(function(){
			fetchContents($(this).attr('id'));
		});		
		$('.file-item').click(function(){
			selectedFiles = [];
			if(single){
				$('.file-item').removeClass('selected');
				$(this).addClass('selected');
			} else {
				$(this).addClass('selected');
			}
			$('.file-item.selected').each(function(){
				selectedFiles.push('FILE: ' + $(this).data('path'));
			});
		});
		$('#delete-file').click(function(e){
			e.preventDefault();
			var folder = $(this).data('folder');
			deleteFile(folder);
		});
		$('#add-file').click(function(e){
			e.preventDefault();
			$('#media-file-upload').click();
		});
		 $('#media-file-upload').change(function(){
		 	var folder = $(this).data('folder');
		 	uploadFile(folder);
        });
		 $('#close-media-modal').click(function(e){
			e.preventDefault();
			hideMediaModal();
        });

		$('#select-file').click(function(e){
			e.preventDefault();
			thisElement.val(selectedFiles);
			angular.element(thisElement).triggerHandler('input');
			selectedFiles = [];
			$('.file-item').removeClass('selected');
			hideMediaModal();
		});
	}

	function fetchContents(folder){
		$.ajax({
			method: "POST",
			url: "assets/js/media-library/api/filesList.php",
			data: { dir: folder }
		}).done(function(data) {
			folderContents = JSON.parse(data);
			folders = folderContents.folders;
			files = folderContents.files;
			dir = "assets/js/media-library/"+folder;
			updateModal(folders, files, dir, folder);
		}).fail(function(error){
			console.log(error);
		});		
	}

	function hideMediaModal(){
		$('.media-library-wrapper').hide();
	}

	function deleteFile(folder){
		var shortFiles = [];
		for (i=0; i<selectedFiles.length; i++){
			var string = selectedFiles[i].substring(30);
			shortFiles.push(string);
		}
		var files = JSON.stringify(shortFiles);
		$.ajax({
			method: "POST",
			url: PLUGINLOCATION + "/api/filesDelete.php",
			data: { files: files }
		}).done(function(data) {
		}).fail(function(error){
			console.log(error);
		});		
		fetchContents(folder);
	}

	function uploadFile(folder){
		var filesToUpload = $('#media-file-upload').prop('files')[0];
		var form_data = new FormData();
		form_data.append('fileToUpload', filesToUpload);
		$.ajax({
			method: "POST",
			url: "assets/js/media-library/api/uploadFile.php",// point to server-side PHP script 
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
		}).done(function(data) {
			fetchContents(folder);
		}).fail(function(error){
			console.log(error);
		});		
	}

	function getPluginLocation(){
		$.ajax({
			method: "POST",
			url: "pluginLocation.php"
		}).done(function(data) {
			PLUGINLOCATION = data;
		}).fail(function(error){
			console.log(error);
		});	
	}

	// onclick show modal
	$(element).click(function(){
		$('.media-library-wrapper').show();
		thisElement = $(this);
		single = thisElement.data('single');
	});
}

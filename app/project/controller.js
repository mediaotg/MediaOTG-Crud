// controller.js

app.controller('projectsCtrl', function($scope, $http){

	// delete project
	$scope.deleteProject = function(id){
		// confirm
		if(confirm("Are you sure?")){
			$http({
				method: 'POST',
				data: { 'id' : id },
				url: 'api/project/delete.php'
			}).then(function successCallback(response){
				Materialize.toast(response.data, 4000);
				$scope.getAll();
			});
		}
	}

	// update project / save changes
	$scope.updateProject = function(){
		$http({
			method: 'POST',
			data: {
				'id' : $scope.id,
				'name' : $scope.name,
				'content' : $scope.content,
				//'challenge' : $scope.challenge,
				//'solution' : $scope.solution,
				//'result' : $scope.result,
				'thumbnail' : $scope.thumbnail,
				'logo' : $scope.logo,
				'gallery' : $scope.gallery
			},
			url: 'api/project/update.php'
		}).then(function successCallback(response){
			Materialize.toast(response.data, 4000);

			$('#modal-project-form').modal('close');
			$scope.clearForm();
			$scope.getAll();
		})
	}

	// get data to fill out form
	$scope.readOne = function(id){
		$('#modal-project-title').text("Edit Project");
		$('#btn-update-project').show();
		$('#btn-create-project').hide();

		// post id of project to be edited
		$http({
			method: 'POST',
			data: {'id' : id},
			url: 'api/project/read_one.php'
		}).then(function successCallback(response){

			// put values in form
			$scope.id = response.data[0]["id"];
			$scope.name = response.data[0]["name"];
			$scope.content = response.data[0]["content"];
			$scope.thumbnail = response.data[0]["thumbnail"];
			$scope.logo = response.data[0]["logo"];
			$scope.gallery = response.data[0]["gallery"];

			// show modal
			$('#modal-project-form').modal('open');
		}).catch(function(data, status, headers, config) {
			Materialize.toast('Unable to retrieve record.', 4000);
		});
	}

	// get data to fill table
	$scope.getAll = function(){
		$http({
			method: 'GET',
			url: 'api/project/read.php'
		}).then(function successCallback(response){
			$scope.names = response.data;
		});
	}

	$scope.showCreateForm = function(){
		// clear form
		$scope.clearForm();

		// change modal title
		$('#modal-project-title').text("Create New Project");

		// hide update project button
		$('#btn-update-project').hide();

		// show create project button
		$('#btn-create-project').show();
	}

	$scope.clearForm = function(){
		$scope.id = "";
		$scope.name = "";
		$scope.content = "";
		$scope.thumbnail = "";
		$scope.logo = "";
		$scope.gallery = "";
	}

	$scope.$watch('logos', function(newValue, oldValue) {
	   if(!newValue || newValue === oldValue) return;
	   console.log('value added');
	   //At this point, newValue contains the new value of your persons array
		$('select').material_select();
	});

	// create new project
	$scope.createProject = function(){
		$http({
			method: 'POST', 
			data: {
				'name' : $scope.name,
				'content' : $scope.content,
				'thumbnail' : $scope.thumbnail,
				'logo' : $scope.logo,
				'gallery' : $scope.gallery
			},
			url: 'api/project/create.php'
		}).then(function successCallback(response){

			// Successfully created
			Materialize.toast(response.data, 4000);

			// close modal and reset
			$('#modal-project-form').modal('close');
			$scope.clearForm();
			$scope.getAll();
		});
	}

	// tinyMCE

	  $scope.tinymceOptions = {
	    plugins: 'link image code',
	    menubar: false,
	    style_formats: [
	    { title: 'Section Header', block: 'h2', classes: 'section-header' },
	    { title: 'Section Content', block: 'p', classes: 'section-text' },
	    { title: 'link', inline: 'a', classes: 'section-link' }
	    ],
	    toolbar: 'styleselect',
	    statusbar: false
	  };
});
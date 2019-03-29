


$("#treeMenu").on("click", ".displayFolders", e => {
	let $this = $(e.currentTarget)

	if( $this.is('input') ){
		$this = $this.next()
		let id = $this.data("id")
		displayToTree(id, $this)
	}else{
		let nodes = $this.data("nodes")
		displayNodesDirectory(nodes)

		let id = $this.data("id")
		displayToDropzone(id)
	}
})


function triggerClickNode(e){
	let folder = $(e).data("folder-id")
	$(e).nextAll().remove()
	displayToDropzone(folder)
}

function displayNodesDirectory(nodes){

	let folder_nodes = $(".nav-container ol#folders_nodes")
	folder_nodes.html("")

	folder_nodes.append(`
		<li class="breadcrumb-item active" onclick="goToRootDirectory()">
			<a href="#"><b>Categorías</b></a>
		</li>
	`)

	nodes.forEach( el => {
		folder_nodes.append(`
			<li class="breadcrumb-item active" onclick="triggerClickNode(this)" data-folder-id="${el.id}">
				<a href="#"><b>${el.value}</b></a>
			</li>
		`)
	});
}


function goToRootDirectory(){
	CURRENT_FOLDER = 0
	displayToDropzone(0)

	let folder_nodes = $(".nav-container ol#folders_nodes")
	folder_nodes.html("")
	folder_nodes.append(`
		<li class="breadcrumb-item active" onclick="goToRootDirectory()">
			<a href="#"><b>Categorías </b></a>
		</li>
	`)
}

function displayToTree(FOLDER_ID, $this){

	let sub_folders = $this.next()

	$.ajax({
		url: `listfolders/${FOLDER_ID}`,
		data: {
			_method: 'POST',
			_token: $('meta[name="csrf-token"]').attr('content')
		},
		type:'POST'
	}).done( resp => {

		let folders = JSON.parse(resp)

		sub_folders.html("")

		folders.forEach((row, index)=>{
			sub_folders.append(
				`
				<div class="folder" id="folder_${row.id}">
					<input type="checkbox" class="displayFolders">
					<a href="#" class="btn btn-arbol displayFolders" data-nodes='${row.parentNodes}' data-id="${row.id}">${row.name}</a>
					<div class="folder">
					</div>
				</div>
				`
			)
		})
	}).fail( err => {
		sub_folders.html("")
		Swal.fire(
			'Ocurrio un error!',
			'',
			'error'
		).then( result => {
			window.location.href=""	
		})
	});
}

function addFolderToTree(folder){

	if( CURRENT_FOLDER == 0 ){
		$(`#treeMenu`).append(`
			<div class="folder" id="folder_${folder.id}">
				<input type="checkbox" class="displayFolders">
				<a href="#" class="btn btn-arbol displayFolders" data-nodes='${folder.parentNodes}' data-id="${folder.id}">${folder.name}</a>
				<div class="folder">
				</div>
			</div>
		`)
	}else{
		let folderparent = $(`#treeMenu #folder_${CURRENT_FOLDER}`).children('.folder')[0]
		$(folderparent).append(`
			<div class="folder" id="folder_${folder.id}">
				<input type="checkbox" class="displayFolders">
				<a href="#" class="btn btn-arbol displayFolders" data-nodes='${folder.parentNodes}' data-id="${folder.id}">${folder.name}</a>
				<div class="folder">
				</div>
			</div>
		`)
	}
}

function displayToDropzone(FOLDER_ID){
	
	CURRENT_FOLDER = FOLDER_ID
	$("#folder_id").val(CURRENT_FOLDER) //dropzone

	displayFolderToDropzone()
	displayFileToDropzone()
}

function displayFolderToDropzone(){

	let dropzone_folder = $("#dropzone #grid_containter_folder")

	$.ajax({
		url: `listfolders/${CURRENT_FOLDER}`,
		data: {
			_method: 'POST',
			_token: $('meta[name="csrf-token"]').attr('content')
		},
		type:'POST'
	}).done( resp => {

		let folders = JSON.parse(resp)

		dropzone_folder.children(".folder_grid").remove()

		folders.forEach((row, index)=>{

			dropzone_folder.append(
				`
				<div class="grid-item right-clickable folder_grid" data-nodes='${row.parentNodes}' data-id="${row.id}" id="${row.id}">
					<div class="item" ondragover="allowDrop(event)" ondragstart="drag(event)" draggable="true" id="${row.id}">
						<div class="grid-container-folder">
							<div class="grid-item-folder">
								<span class="fa fa-folder"></span>
							</div>
							<div class="grid-item-folder">
								<b class="des title folder-name">${row.name}</b>
							</div>
						</div>
					</div>
				</div>
				`
			)
		})
	}).fail( err => {
		dropzone_folder.html("")
		Swal.fire(
			'Ocurrio un error!',
			'',
			'error'
		)
	});
}

function displayFileToDropzone(){

	let dropzone_file = $("#dropzone #grid_containter_file")

	$.ajax({
		url: `listfiles/${CURRENT_FOLDER}`, //folder id
		data: {
			_method: 'POST',
			_token: $('meta[name="csrf-token"]').attr('content')
		},
		type:'POST'
	}).done(function (resp) {
		let files = JSON.parse(resp)

		dropzone_file.children(".file_grid").remove()

		files.forEach( row => {
			let icon = 'fa-file'
			let color = ''

			switch (row.extension) {
				case 'txt':
					icon = 'fa-file-text'
					color = 'gray'
					break;
				case 'pdf':
					icon = 'fa-file-pdf-o'
					color = 'text-danger'
					break;
				case 'jpg':
					icon = 'fa-file-image-o'
					break;
				case 'xlsx':
					icon = 'fa-file-excel-o'
					color = 'text-success'
					break;
				default:
					break;
			}

			dropzone_file.append(
				`
				<div class="grid-item tag-wrapper right-clickable file_grid" data-name="${row.name}" id="${row.id}" path="${row.path}${row.fullname}">
					<div class="item tag file" data-id="${row.id}">
						<div class="grid-container-folder">
							<div class="grid-item-folder ">
								<span class="${color} fa ${icon}"></span>
							</div>
							<div class="grid-item-folder">
								<b class="des title file-name" style="word-break: break-all;">${row.fullname}</b>
							</div>
						</div>
					</div>
				</div>
				`
			)
		})
	}).fail( err => {
		Swal.fire(
			'Ocurrio un error!',
			'',
			'error'
		).then( result => {
			window.location.href=""	
		})
	});
}

// right click
$("#dropzone").on("contextmenu", ".right-clickable", function (e) {
	e.preventDefault();

	var $this = $(e.currentTarget)

	var file_id = $this.attr("id")
	var path = $this.attr("path")
	var url = `https://pruebas.mcontrolhelpdesk.com/storage/${path}`

	if($this.attr("class").includes("file_grid")){
		$("ul.contextMenu li a.download").attr("href", url)
		$("ul.contextMenu li a.view").attr("href", url)
		$("ul.contextMenu li a.delete_file").attr("file_id", file_id)
		$("ul.contextMenu li a.rename_file").attr("name", $this.data("name"))
		$("ul.contextMenu li a.rename_file").attr("file_id", file_id)
	
		$("ul.contextMenu.right-click-folder-menu").fadeOut("fast");

		$("ul.contextMenu.right-click-file-menu")
			.show()
			.css({
				top: e.pageY + 15,
				left: e.pageX + 10
			});
	}
	else if($this.attr("class").includes("folder_grid")){
		$("ul.right-click-folder-menu li a.rename").attr("folder_id", file_id)
		$("ul.contextMenu li a.rename").attr("name", $this.find(".folder-name").text())
		$("ul.contextMenu li a.delete").attr("folder_id", file_id)
	
		$("ul.contextMenu.right-click-file-menu").fadeOut("fast");

		$("ul.contextMenu.right-click-folder-menu")
			.show()
			.css({
				top: e.pageY + 15,
				left: e.pageX + 10
			});
	}
	return false
});


// FILES
$("ul.contextMenu li a.rename_file").click( e => {
	let $this = $(e.currentTarget)
	let currentName = $this.attr("name")
	let file_id = $this.attr("file_id")
	renameFile(currentName, file_id)
})
$("ul.contextMenu li a.download").click(()=>{
	$("ul.contextMenu").fadeOut("fast");
})
$("ul.contextMenu li a.view").click(()=>{
	$("ul.contextMenu").fadeOut("fast");
})
$("ul.contextMenu li a.delete_file").click( e => {

	let file_id = $(e.currentTarget).attr("file_id")

	deleteFile(file_id)
})

// FOLDER 
$("ul.contextMenu li a.rename").click( e => {
	let $this = $(e.currentTarget)
	let currentName = $this.attr("name")
	let folder_id = $this.attr("folder_id")
	renameFolder(currentName, folder_id)
})

$("ul.contextMenu li a.delete").click( e => {
	let $this = $(e.currentTarget)
	let folder_id = $this.attr("folder_id")
	deleteFolder(folder_id)
})

//double click
$("#grid_containter_folder").on("dblclick", ".folder_grid", function (e) {
	e.preventDefault();
	
	let $this = $(e.currentTarget)

	let folder_id = $this.data("id")

	let nodes = $this.data("nodes")
	displayNodesDirectory(nodes)

	// $(`#treeMenu #folder_${folder_id} a`).trigger("click")

	displayToDropzone(folder_id)

	return false
});

$(document).click(function () {

	// let isHovered = $("ul.contextMenu").is(":hover");
	let isHovered = $("ul.contextMenu:hover");
	if (isHovered) {
		$("ul.contextMenu").fadeOut("fast");
	}
});

$(document).bind("contextmenu", function (event) {
	// let isHovered = $("ul.contextMenu").is(":hover");
	let isHovered = $("ul.contextMenu:hover");
	if (isHovered) {
		$("ul.contextMenu").fadeOut("fast");
	}
});
// click derecho js

$("#select-client").change((e) => {
	let $this = $(e.currentTarget)
	let value = $this.val()

	let estacion = value.split('|')[0]
	let id = value.split('|')[1]
	$("#estac_selected").text(estacion)
	$("#estac_selected").attr('estacion', id)
	$("#input_estacion").val(id)
})

$("#dropzone").on('click', '.tag', e => {
	let $this = $(e.currentTarget)

	let current_actives = $("#dropzone .item-active")

	if($this.attr("class").includes("item-active")){
		$("#dropzone .tag").removeClass("item-active");
		$(".tag-informations").toggleClass("show");
		$("#wrapper").toggleClass("active");
	}else{
		if(current_actives.length > 0){
			$("#dropzone .tag").removeClass("item-active");
		}

		if($(".tag-informations").attr("class").includes("show")){
			displayDetailsFile($this.data("id"))
		}
		else{
			$(".tag-informations").toggleClass("show");
			$("#wrapper").toggleClass("active");

			displayDetailsFile($this.data("id"))
		}
		$this.toggleClass("item-active");
	}
});

var loading = `<center id="loading"><img src="https://pruebas.mcontrolhelpdesk.com//img/loading.gif" width="50%"></center>`

function displayDetailsFile(id){

	$(".tag-informations .contentinfo").append(loading)

	$.ajax({
		url: `detailsfile/${id}`, //folder id
		data: {
			_method: 'POST',
			_token: $('meta[name="csrf-token"]').attr('content')
		},
		type:'POST'
	}).done(function (resp) {
		let file = JSON.parse(resp)

		file = file[0]

		let html = $(".tag-informations .contentinfo")
		html.find("#file_name").html(file.name)
		html.find("#file_type").html("Archivo")
		html.find("#file_location").html(file.location)
		html.find("#file_created").html(file.created_at)
		html.find("#file_inserted_by").html(file.user_name)
		html.find("#client_name").html(file.client_name)
		
		$(".tag-informations .contentinfo #loading").remove()
	}).fail(function (err) {
		Swal.fire(
			'Ocurrio un error al obtener datos de archivo!',
			'',
			'error'
		).then( result => {
			window.location.href=""	
		})
	});
}

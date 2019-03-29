

<nav id="sidebar" style="background-color:#e9ecef;">
	<div class="container" style="margin-top: 100px;">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				<div class="file-manager font-weight-bold" style="color:#343a40;">
					<div class="hr-line-dashed"></div>
					{{-- CREATE NEW FOLDER  --}}
					@if(Auth::user()->role =='admin' || Auth::user()->role =='super')
					<button class="btn btn-outline-primary btn-block" onclick="newFolder();"><i class="fa fa-plus"></i> <b>Crear Carpeta</b></button>
					@endif
					<div class="hr-line-dashed"></div>
					<br>
					<h5>Categorias</h5>
					{{-- Arbolito --}}
					<div id="treeMenu" class="arbolito">
						@foreach ($folders as $folder)
							<div class="folder" id="folder_{{ $folder->id }}">
								<input type="checkbox" class="displayFolders">
								<a href="#" class="btn btn-arbol displayFolders" data-nodes="{{ $folder->parentNodes }}" data-id="{{ $folder->id }}">{{ $folder->name }}</a>
								<div class="folder">
								</div>
							</div>
						@endforeach
					</div>
					{{-- //fin arbolito --}}

					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
</nav>
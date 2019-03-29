@extends('admin.layouts.master')

@section('page','Lista de Clientes')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10  offset-md-1 bg-white">
            <div class="card-header">
                <H2>LISTA DE CLIENTES</H2>
            </div>
            <div class="card-body">
				<div class="col-md-10 mb-3">
					<a class="btn btn-outline-success" href=" {{ route('admin.client.create') }} ">
						<i class="fa fa-plus-circle"></i>Agregar un Cliente
					</a>
				</div>
                <table class="table table-hover table-striped" id="datatable-clientes" style="width:100%">
                    <thead>
                        <tr>
                            <th>Ruc</th>
                            <th>Razon social</th>
                            <th>Direccion</th>
                            <th>Correo</th>
                            <th>Grupo</th>
                            <th width=""> </th>
                        </tr>
					</thead>
					<tbody>
					@foreach ($clients as $client)
						<tr>
							<td>{{ $client->ruc }}</td>
							<td>{{ $client->name }}</td>
							<td>{{ $client->direction }}</td>
							<td>{{ $client->email }}</td>
							<td>{{ $client->group }}</td>
							<td>
								<button class="btn btn-info btn-sm details" data-id="{{ $client->id }}"><i class="fa fa-eye"></i></button>
								<a class="btn btn-primary btn-sm" href="{{ route('admin.client.edit', $client->id) }}"><i class="fa fa-edit"></i></a>
								<button class="btn btn-danger btn-sm delete" data-id="{{ $client->id }}"><i class="fa fa-trash"></i></button>
							</td>
						</tr>
						@endforeach
					</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script type="text/javascript">
    //MODAL VER DETALLES DEL CLIENTE   
    $("#datatable-clientes").on("click", ".details", function (e) {

        var id = $(this).data("id");

        $.ajax({
            url: `client/${id}`,
            data: {
                _method: 'GET',
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            success: function (data) {
				var contactos = JSON.parse(data.contacts);

				if(!contactos) contactos = []

                var filas = "";
                for (let index = 0; index < contactos.length; index++) {
                    const contacto = contactos[index];
                    filas +=
                    `
                        <tr>
                            <td>${contacto.nombre}</td>
                            <td>${contacto.correo}</td>
                            <td>${contacto.cargo}</td>
                            <td>${contacto.telefono}</td>                         
                        </tr> 
                    `
                }
                var html =
                `
                    <div class="row" style="font-size:1rem">
                        <div class=" col-md-4">
                            <label class="float-left font-weight-bold"> RUC :</label> <br>
                            <label class="float-left font-weight-normal">${data.ruc}</label>
                        </div>

                        <div class=" col-md-8">
                            <label class='float-left font-weight-bold'>Razon social : </label> <br>
                            <label class='float-left font-weight-normal' style="text-align:left !important;">${data.name}</label>
                        </div>

                        <div class="col-md-12">
                            <label class='float-left font-weight-bold'>Direccion : </label> <br>
                            <label class='float-left font-weight-normal' style="text-align:left !important;" name="direccion">${data.direction}</label>
                        </div>

                        <div class=" col-md-6">
                            <label class='float-left font-weight-bold'>Bandera : </label> <br><br>
                            <label class='float-left font-weight-normal' style="text-align:left !important;">${data.flag}</label>
                        </div>
                        
                        <div class="col-md-6 ">
                            <label class='float-left font-weight-bold' for="ClientGrupo">Grupo : </label> <br><br>
                            <label class='float-left font-weight-normal' style="text-align:left !important;">${data.group}</label>
                        </div>

                        <div class="col-md-12 table-responsive table-sm">
                            <table class="table">
                                <thead>
									<th>Nombre</th>
									<th>Correo</th>
									<th>Cargo</th>
									<th>Telefono</th>
                                </thead>
                                <tbody>
                                	${filas}
                                </tbody>
                            </table>
                        </div>
                    </div>
                `;
                Swal.fire({
                    title: '<strong>  <u>Datos del Cliente</u> </strong>',
                    type: '',
                    html: html,
                    showCloseButton: false,
                    showCancelButton: false,
                    focusConfirm: false,
                })
            }
        })
        return;
    });

	$('#datatable-clientes').on("click", ".delete", function (e) {

		var id = $(this).data("id");

		Swal.fire({
			title: 'Estas seguro?',
			text: "El cliente sera eliminado!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Sí, borralo!'
		}).then((result) => {
			if (result.value) 
			{
				$.ajax(
				{
					url: `client/${id}/delete`,
					data: {
						_method: 'POST',
						_token: $('meta[name="csrf-token"]').attr('content')
					},
					type: 'POST'
				}).done(function (r)
				{
					Swal.fire(
						'Eliminado!',
						'Cliente eliminado correctamente.',
						'success'
					).then( result => {
						window.location.href=""	
					})
				}).fail(function (xhr) {
					Swal.fire(
						'Ocurrio un error!',
						'El cliente no pudo eliminarse.',
						'error'
					).then( result => {
						window.location.href=""	
					})
				});
			}
		})
	});
</script>
@endsection

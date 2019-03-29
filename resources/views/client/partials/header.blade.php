<header>
	<!-- NAVBAR SUPERIOR-->
	<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top alert-home">
		<a class="navbar-brand" href="#">
			<img src="{{asset('img/solu.jpg')}}" width="30" height="30" class="d-inline-block align-top" alt="">
			<b class="text-primary">SOLUGRIFOS</b> <small><b> - Plan</b> <b class="text-success">VERDE</b></small>
		</a>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarBS"
			aria-controls="navbarBS" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarBS">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item" style="margin: 0 10px 0 10px;">
					<div class="dropdown">
						<button class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-th"></i>
						</button>

						<div class="dropdown-menu dropdown-menu-right text-center"
							style=" min-width: 20rem; padding: 0.5rem 0;">
							<form class="px-4 py-3">
								<style>
									.list-perf:hover {
										background-color: #eaeaea;
									}
								</style>
								<div class="row">
									<div class="col-md-4 ">
										<div class="list-perf card border-light mb-3" style="max-width: 18rem;">
											<a href="{{ route('admin') }}" class="btn" title="Documentos"
												data-toggle="tooltip" data-placement="bottom">
												<img src="{{asset('img/documents.svg')}}" class="card-img-top">
											</a>
										</div>
									</div>
								</div>
							</form>
							<div class="dropdown-divider"></div>

							<div class="row">
								<div class="col-md-12">
									<label class=" profile-usertitle-name font-weight-bold text-center">
										{{ Auth::User()->name }}
									</label>
								</div>
								<div class="col-md-12">
									<label class=" profile-usertitle-status text-center">
										{{ Auth::User()->email }}
									</label>
								</div>
							</div>
							<div class="dropdown-divider"></div>

							@guest
								<a href=" {{ route('login') }} " class="btn btn-sm btn-outline-primary">Ingresar</a>
							@else
								<a class="logout btn btn-sm btn-danger" href="{{ route('logout') }}"
									onclick="event.preventDefault();
													document.getElementById('logout-form').submit();">
									Cerrar sesión
								</a>

								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									@csrf
								</form>
							@endguest
						</div>
					</div>
				</li>
			</ul>
		</div>
	</nav>
</header>
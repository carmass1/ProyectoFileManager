<style>
body,html {
  margin: 0;
  padding: 0;
  height: 100%;
  width: 100%;
  box-sizing: border-box;
  background-color:#fff;
}

body {
  font-family: 'Open Sans', sans-serif;
}

.left-sidebar {
  width: 480px;
  height: 100%;
  bottom: 0;
  position: fixed;
  right: 0;
  background-color: #fff;
  transition: all 0.3s ease;
  z-index:6666;
  box-shadow: -3px 0px 5px 0px rgba(177,177,177,.5);
}

#menu ul {
  margin: 0;
  padding: 0;
  list-style: none;
}

.main-container {
  height: 100%;
  /* width: calc(100% - 200px); */
  margin-right: 480px;
  background-color: #91f1ff;
}

section {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  /* background-color:red; */
}
section:nth-child(odd) {
  background: #000;
}

.container {
  display: flex;
  align-content: center;
  align-items: center;
  flex-direction: column;
  flex-wrap: nowrap;
  height: 100%;
  justify-content: space-around;
  position: relative;
  width: 100%;
}
.container section {
  width: 100%;
  height: 100vh;
  flex: 1;
  display: flex;
  text-align: center;
  position: relative;
  overflow: hidden;
  background-color: #000;
}


body
{
  overflow-x: hidden;
}

.scroll
{
  position: fixed;
  bottom: 0;
  left: 0;
}


</style>
@extends('layouts.app')

@section('content')

<div class="left-sidebar">
	<div id="menu">
    	<div class="container">
            <div class="row justify-content-center">
            	<h1>Iniciar Sesion</h1>
				<div class="col-md-11">
					<div class="iconlogin" style="text-align:center;">
						<img src="http://solugrifos.com/wp-content/uploads/2019/01/Logotipo-Final-Solugrifos.png" class='mb-1 mt-1' width="50%">
					</div>
					<form method="POST" action="{{ route('login') }}" autocomplete="off">
						@csrf
						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo') }}</label>

							<div class="col-md-6">
								<input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" required autofocus>

								@if ($errors->has('email'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group row">
							<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

							<div class="col-md-6">
								<!-- <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required> -->
								<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

								@if ($errors->has('password'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('password') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-12 ">
								<div class="form-check" style="text-align:center;">
									<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember')?'checked' : '' }}>

									<label class="form-check-label" for="remember">
										{{ __('Recordar mis datos') }}
									</label>
								</div>
							</div>
						</div>

						<div class="form-group row mb-0">
							<div class="col-md-12 ml-4">
								<button type="submit" class="btn btn-info btn-block">
									{{ __('Login') }}
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="main-container">

	<style>
		.fondo
{
	line-height: 0;
  z-index: 1;
  width: 3000px;
}

.clouds
{
	line-height: 0;
  z-index: 1;
  width: 4000px;
}


.grifos
{
	line-height: 0;
  z-index: 500;
  width: 4500px;
}

.mensaje
{
  z-index: 1000;
  width: 6000px;
}

.front2
{
	z-index: 1500;
  position: fixed;
  bottom: 0;
  left: 0;
}

.arbol
{
  z-index: 1000;
  width: 4500px;
}
#leftgear{
  top: 774px;
  width: 40px;
  left: 215px;
}
#rightgear{
  top: 774px;
  width: 40px;
  left: 376px;
}

	</style>

	  <div class="fondo scroll">
        <img src="{{asset('img/roadback.png')}}" alt="" />
    </div>

    <div class="clouds scroll">
      <img src="{{asset('img/roadclouds.png')}}" alt="" />
    </div>

    <div class="grifos scroll">
		  <img src="{{asset('img/roadgrifo.png')}}" alt="" />
	  </div>
	
    <div class="mensaje scroll">
		  <img src="{{asset('img/roadtext.png')}}" alt="" />
	  </div>

  	<div class="arbol scroll">
  		<img src="{{asset('img/roadtree.png')}}" alt="" />
  	</div>

  	<div class="front2">
          <img src="{{asset('img/roadcar2.png')}}" alt="" />
          <img src="{{asset('img/gear.svg')}}" style="position: absolute; z-index:9999" alt id="leftgear">
          <img src="{{asset('img/gear.svg')}}" style="position: absolute; z-index:9999" alt id="rightgear">
    </div>


@endsection


@section('script')
<script type="text/javascript">
	
	(function($) {
    $.jInvertScroll = function(sel, options) {
        var defaults = {
            width: 'auto',		    // The horizontal container width
            height: 'auto',		    // How far the user can scroll down (shorter distance = faster scrolling)
            onScroll: function(percent) {  // Callback fired when the user scrolls down, the percentage of how far the user has scrolled down gets passed as parameter (format: 0.xxxx - 1.0000)
                // do whatever you like
            }
        };
        
        var config = $.extend(defaults, options);
        
        if(typeof sel === 'Object' && sel.length > 0) {
            return;
        }
        
        var elements = [];
        var longest = 0;
        
        // Extract all selected elements from dom and save them into an array
        $.each(sel, function(i, val) {
            $(val).each(function(e) {
                var tmp = {
                    width: $(this).width(),
                    height: $(this).height(),
                    el: $(this)
                }
                
                elements.push(tmp);
                
                if(longest < tmp.width) {
                    longest = tmp.width;
                }
            });
        });
        
        // Use the longest elements width + height if set to auto
        if(config.width == 'auto') {
            config.width = longest;
        }
        
        if(config.height == 'auto') {
            config.height = longest;
        }
        
        // Set the body to the selected height
        $('body').css('height', config.height+'px');
        
        // Listen for the actual scroll event
        $(window).on('scroll resize', function(e) {
            var currY = $(this).scrollTop();
            var totalHeight = $(document).height();
            var winHeight = $(this).height();
            var winWidth = $(this).width();
            
            // Current percentual position
            var percent = (currY / (totalHeight - winHeight)).toFixed(4);
            
            // Call the onScroll callback
            if(typeof config.onScroll === 'function') {
                config.onScroll.call(this, percent);
            }
            
            // do the position calculation for each element
            $.each(elements, function(i, el) {
                var pos = Math.floor((el.width - winWidth) * percent) * -1;
                el.el.css('left', pos);
            });
        });
    };
}(jQuery));


    (function($) {
        $.jInvertScroll(['.scroll'],        // an array containing the selector(s) for the elements you want to animate
            {
            height: 6000,                   // optional: define the height the user can scroll, otherwise the overall length will be taken as scrollable height
            onScroll: function(percent) {   //optional: callback function that will be called when the user scrolls down, useful for animating other things on the page
                console.log(percent);
            }
        });
    }(jQuery));

    $(window).scroll(function() {
    var theta = $(window).scrollTop() / 10 % Math.PI;
    $('#leftgear').css({ transform: 'rotate(' + theta + 'rad)' });
    $('#rightgear').css({ transform: 'rotate(' + theta + 'rad)' });
    });

    </script>


@endsection
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>{{ $title }}</title>

		{{ HTML::style('/css/bootstrap.min.css') }}
		{{ HTML::style('/css/bootstrap-theme.css') }}

	</head>	
	<body>

		<div id="nav">
			<div class="navbar navbar-inverse">
				<a class="navbar-brand">MyMovieDB</a>
			</div>
		</div> <!-- End Nav Dic -->

		@if(Session::has('message'))
			<center>{{ Session::get('message') }}</center>
			<br>
		@endif

		<h2 style="text-align: center;">Login</h2>
		<br><br>


		@if($errors->any())
		<ul>
			{{ implode ('', $errors->all('<li>:message</li>'))}}
		</ul>
		@endif


		<center>
			<div class="well col-md-4 col-md-offset-4" >
				<form method="post" action="{{ URL::to('login') }}">
					<label>Username</label><br>
					<input type="text" id="username" name="username" placeholder="Username">
					<br><br>

					<label>Password</label><br>
					<input type="password" id="password" name="password" placeholder="Password">
					<br><br>
					
					<button class="btn btn-success" type="submit" value="Login">Login</button>
				
					<br><br>
					<div>
						<!-- Display the signup link -->
						<p>Need an account? {{ HTML::link('signup', 'Signup here!') }}</p>
						<br>
						<center> &copy; www.mymoviedb.local {{ date ('Y') }} </center>
					</div>


				</form>
			</div>
		</center>

		<!-- Javascript Files required for page -->
		<script src="/js/bootstrap.min.js"></script>
	</body>
</html>

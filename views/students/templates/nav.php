<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
	<div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
		<a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
			<span class="fs-5 d-none d-sm-inline">Student Panel</span>
		</a>
		<ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
			<li class="nav-item">
				<a href="/" class="nav-link" aria-current="page">
					<i class="fa fa-home" aria-hidden="true"></i>
					Home
				</a>
			</li>
			<li class="nav-item">
			<?php if (strpos($_SERVER['REQUEST_URI'], "/dashboard") !== false) : ?>
					<a href="/students/dashboard" class="nav-link active " aria-current="page">
					<?php else : ?>
						<a href="/students/dashboard" class="nav-link " aria-current="page">
						<?php endif; ?>
					<i class="fa fa-tachometer" aria-hidden="true"></i>
					Dashboard
				</a>
			</li>

			<li class="nav-item">
			<?php if (strpos($_SERVER['REQUEST_URI'], "/students/messages") !== false) : ?>
					<a href="/students/students" class="nav-link active " aria-current="page">
					<?php else : ?>
						<a href="/students/messages" class="nav-link " aria-current="page">
						<?php endif; ?>
						<i class="far fa-comments"></i>
					Messages 
				</a>
			</li>

			<li class="nav-item">
			<?php if (strpos($_SERVER['REQUEST_URI'], "classrooms") !== false) : ?>
					<a href="/students/classrooms" class="nav-link active " aria-current="page">
					<?php else : ?>
						<a href="/students/classrooms" class="nav-link " aria-current="page">
						<?php endif; ?>
						<i class="fas fa-chalkboard"></i>
					Classrooms
				</a>
			</li>
		
		
			<li>
			<?php if (strpos($_SERVER['REQUEST_URI'], "/students/courses") !== false) : ?>
				<a href="/students/courses" class="nav-link active" aria-current="page">
					<?php else : ?>
						<a href="/students/courses" class="nav-link" aria-current="page">
						<?php endif; ?>
						<i class="fas fa-layer-group"></i>

					Courses
				</a>
			</li>
		
			<li>
				<a href="/signout" class="nav-link" aria-current="page">
					<i class="fa fa-sign-out" aria-hidden="true"></i>
					Signout
				</a>
			</li>
		</ul>
		<hr>
		<div class="dropdown pb-4">
			<a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
			<img src="<?= $_SESSION["user"]["avatar"] ?>.svg" alt="hugenerd" width="30" height="30" class="rounded-circle">
				<span class="d-none d-sm-inline mx-1"><?= $_SESSION["first_name"] ?></span>
			</a>
			<ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">

				<li>
					<hr class="dropdown-divider">
				</li>
				<li><a class="dropdown-item" href="/signout">Sign out</a></li>
			</ul>
		</div>
	</div>
</div>
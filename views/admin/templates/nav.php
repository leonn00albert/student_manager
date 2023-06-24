<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
	<div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
		<a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
			<span class="fs-5 d-none d-sm-inline">Admin Panel</span>
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
					<a href="/admin/dashboard" class="nav-link active " aria-current="page">
					<?php else : ?>
						<a href="/admin/dashboard" class="nav-link " aria-current="page">
						<?php endif; ?>
					<i class="fa fa-tachometer" aria-hidden="true"></i>
					Dashboard
				</a>
			</li>

			<li class="nav-item">
			<?php if (strpos($_SERVER['REQUEST_URI'], "/students") !== false) : ?>
					<a href="/admin/students" class="nav-link active " aria-current="page">
					<?php else : ?>
						<a href="/admin/students" class="nav-link " aria-current="page">
						<?php endif; ?>
					<i class="fa fa-bar-chart" aria-hidden="true"></i>
					Students
				</a>
			</li>

			<li class="nav-item">
			<?php if (strpos($_SERVER['REQUEST_URI'], "classrooms") !== false) : ?>
					<a href="/admin/classrooms" class="nav-link active " aria-current="page">
					<?php else : ?>
						<a href="/admin/classrooms" class="nav-link " aria-current="page">
						<?php endif; ?>
					<i class="fa  fa-map-marker" aria-hidden="true"></i>
					Classrooms
				</a>
			</li>
			<li>
			<li>
				<?php if (strpos($_SERVER['REQUEST_URI'], "carAdmin.php") !== false) : ?>
					<a href="/views/admin/carAdmin.php" class="nav-link active " aria-current="page">
					<?php else : ?>
						<a href="/views/admin/carAdmin.php" class="nav-link " aria-current="page">
						<?php endif; ?>
					<i class="fa fa-car" aria-hidden="true"></i>
					Teachers
				</a>
			</li>
			
			</li>
			<li>
				<?php if (strpos($_SERVER['REQUEST_URI'], "booking.php") !== false) : ?>
					<a href="/views/admin/booking.php" class="nav-link active" aria-current="page">
					<?php else : ?>
						<a href="/views/admin/booking.php" class="nav-link" aria-current="page">
						<?php endif; ?>
						<i class="fa fa-calendar" aria-hidden="true"></i>
						Settings
						</a>
			</li>
			<li>
			<li>
				<?php if (strpos($_SERVER['REQUEST_URI'], "/admin/cms") !== false) : ?>
					<a href="/admin/cms" class="nav-link active" aria-current="page">
					<?php else : ?>
						<a href="/admin/cms" class="nav-link" aria-current="page">
						<?php endif; ?>
						<i class="fa fa-star" aria-hidden="true"></i>
						CMS
						</a>
			</li>
			<li>
			<?php if (strpos($_SERVER['REQUEST_URI'], "/admin/courses") !== false) : ?>
				<a href="/admin/courses" class="nav-link active" aria-current="page">
					<?php else : ?>
						<a href="/admin/courses" class="nav-link" aria-current="page">
						<?php endif; ?>
					<i class="fa fa-bars" aria-hidden="true"></i>

					Courses
				</a>
			</li>
			<li>
			<?php if (strpos($_SERVER['REQUEST_URI'], "userAdmin.php") !== false) : ?>
				<a href="/views/admin/userAdmin.php" class="nav-link active" aria-current="page">
					<?php else : ?>
						<a href="/views/admin/userAdmin.php" class="nav-link" aria-current="page">
						<?php endif; ?>
					<i class="fa fa-user" aria-hidden="true"></i>

					Users
				</a>
			</li>
			<li>
				<a href="/views/signout.php" class="nav-link" aria-current="page">
					<i class="fa fa-sign-out" aria-hidden="true"></i>

					Signout
				</a>
			</li>
		</ul>
		<hr>
		<div class="dropdown pb-4">
			<a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
				<img src="https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
				<span class="d-none d-sm-inline mx-1"><?= $_SESSION["userName"] ?></span>
			</a>
			<ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">

				<li>
					<hr class="dropdown-divider">
				</li>
				<li><a class="dropdown-item" href="/views/signout.php">Sign out</a></li>
			</ul>
		</div>
	</div>
</div>
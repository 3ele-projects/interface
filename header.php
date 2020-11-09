<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Interface
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<!-- Custom fonts for this template-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">


	<?php wp_head(); ?>
</head>

<body id="page-top" <?php body_class(); ?>>

	<?php wp_body_open(); ?>
	<?php
	// Set the Current Author Variable $curauth

	global $current_user; // Use global

	if (!is_page_template('login.php')) { ?>

		<!-- Page Wrapper -->
		<div id="wrapper">

			<!-- Sidebar -->
			<div class="navbar-nav sidebar-dark sidebar accordion">
				<div class="navbar-innner ">
					<ul class="navbar-nav " id="accordionSidebar" style="display:flex; height:100vh;">

						<!-- Sidebar - Brand -->
						<a class="sidebar-brand d-flex" href="<?php echo get_home_url(); ?> ">
							<div class="sidebar-brand-icon rotate-n-15">

							</div>
							<div class="sidebar-brand-text">Website Invest</div>
						</a>

						<!-- Divider -->

						<hr class="sidebar-divider my-0">

						<?php wp_nav_menu(array('theme_location' => 'menu-1', 'container' => '', 'items_wrap' => '%3$s',     'add_li_class'  => 'nav-item')); ?>



						<!-- Divider -->
						<hr class="sidebar-divider">

						<!-- Heading -->

						<li class="nav-link menu-item nav-item mt-auto mb-3"><a class="nav-link" href="<?php echo wp_logout_url(); ?>"><i class="fas fa-sign-out-alt" aria-hidden="true"></i>Logout</a></li>


					</ul>
				</div>
			</div>
			<div id="content-wrapper" class="d-flex flex-column">

				<!-- Main Content -->
				<div id="content">

					<!-- Topbar -->
					<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

						<!-- Sidebar Toggle (Topbar) -->
						<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
							<i class="fa fa-bars"></i>
						</button>

						<!-- Topbar Search -->
						<?php // echo get_search_form(  );
						?>



						<!-- Topbar Navbar -->
						<ul class="navbar-nav ml-auto">

							<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo get_home_url(); ?> ">

								<div class="sidebar-brand-text mx-3">Website Invest</div>
							</a>


							<div class="topbar-divider d-none d-sm-block"></div>

							<!-- Nav Item - User Information -->
							<li class="nav-item dropdown no-arrow">
								<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $current_user->user_login ?> </span>
								</a>

							</li>

						</ul>

					</nav>
					<!-- End of Topbar -->

				<?php } ?>
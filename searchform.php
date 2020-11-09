	<!-- Topbar Search -->

	<form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="<?php echo esc_url(home_url('/')); ?>">
		<div class="input-group">
			<input type="text" class="search-field" class="form-control bg-light border-0 small" name="s" placeholder="Search" value="<?php echo get_search_query(); ?>">

			<div class="input-group-append">
				<input class="btn btn-primary" type="submit" value="S" />

				</button>
			</div>
		</div>
	</form>
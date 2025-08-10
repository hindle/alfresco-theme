<?php get_header(); ?>

</div>	<!-- End rilee-header-wrapper -->

<div id="rilee-content-container" class="rilee-single-page">

	<div class="rilee-container">

		<div id="rilee-content" class="rilee-default-width">	

			<?php if(have_posts()) { 

				while(have_posts()) { 

					the_post();

					get_template_part('content', 'page'); 	
				}
				
			} ?>

		</div>	<!--end rilee-content -->	

	</div>	<!--end rilee-container -->	
		
	<?php get_footer(); ?>		
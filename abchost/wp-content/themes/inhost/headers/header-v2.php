<!--Header-->
<div class="header header-v2 <?php if(!$inwave_cfg['show-pageheading'] & !$inwave_cfg['slide-id']) echo 'static-position-menu' ?>">
	<div class="header-middle">
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="header-logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img alt="logo" src="<?php echo esc_url($smof_data['logo']); ?>"/></a>
					</div>
				</div>

				<div class="col-sm-9">
					<div class="header-menu">
						<?php include(inwave_get_file_path('blocks/menu')); ?>
					</div>
				</div>
			</div>
			<?php if($smof_data['show_quick_access']):  ?>
				<div class="quick-access"></div>
			<?php endif; ?>
		</div>
	</div>
</div>
<div class="content-wrapper">
<!--End Header-->
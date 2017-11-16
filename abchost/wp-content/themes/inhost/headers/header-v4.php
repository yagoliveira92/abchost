<div class="header header-v4 <?php if(!$inwave_cfg['show-pageheading'] & !$inwave_cfg['slide-id']) echo 'static-position-menu' ?>">
	<div class="header-inner">
		<div class="header-middle">
			<div class="container">
				<div class="row">
					<div class="col-sm-3">
						<div class="header-logo">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img alt="logo" src="<?php echo esc_url($smof_data['logo']); ?>"/></a>
						</div>
					</div>

					<div class="col-sm-9">
                        <?php if (isset($smof_data['header_extra_content']) && $smof_data['header_extra_content']) { ?>
                            <?php echo wp_kses_post($smof_data['header_extra_content']); ?>
                        <?php } ?>
					</div>
				</div>
				<?php if($smof_data['show_quick_access']):  ?>
					<div class="quick-access"></div>
				<?php endif; ?>
			</div>
		</div>
		<div class="header-menu">
			<div class="container">
				<?php include(inwave_get_file_path('blocks/menu')); ?>
			</div>
		</div>
	</div>
</div>
<div class="content-wrapper">
<!--End Header-->
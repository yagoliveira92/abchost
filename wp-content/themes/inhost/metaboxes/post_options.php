<div class="inwave_metabox">
    <?php
    $this->select('slider',
        'Select Revolution  Slider',
        $this->getRevoSlider()
    );
    ?>
    <?php
    $this->select('show_pageheading',
        'Show page heading',
        array(''=>'Default', 'yes' => 'Yes', 'no' => 'No'),
        ''
    );
    ?>
    <?php
    $this->upload('pageheading_bg','Page heading background');
    ?>
    <?php
    $this->upload('logo','Change logo');
    ?>
    <?php
    $this->text('page_title_custom',
        'Page Title',
        ''
    );
    ?>
    <?php
    $this->text('page_sub_title',
        'Page Sub Title',
        ''
    );
    ?>
    <?php
    $this->select('sidebar_position',
        'Sidebar Position',
        array('' => 'Default','none' => 'Without Sidebar', 'right' => 'Right', 'left' => 'Left', 'bottom' => 'Bottom'),
        ''
    );
    ?>
    <?php
    $this->select('sidebar_name',
        'Sidebar Name',
        $this->getSideBars(),
        ''
    );
    ?>
    <?php
    $this->select('header_option',
        'Header style',
        array('' => 'Default','v1' => 'Header Style 1', 'v2' => 'Header Style 2', 'v3' => 'Header Style 3','v4' => 'Header Style 4'),
        ''
    );
    ?>
    <?php
    $this->select('primary_menu',
        'Primary Menu',
        $this->getMenuList(),
        ''
    );
    ?>
    <?php
    $this->select('footer_option',
        'Footer style',
        array('' => 'Default', 'footer-2' => 'Footer Onepage'),
        ''
    );
    ?>
	<?php
    $this->select('theme_style',
        'Theme Style',
		array('' => 'Default', 'light' => 'Light', 'dark' => 'Dark'),
        ''
    );
    ?>
</div>
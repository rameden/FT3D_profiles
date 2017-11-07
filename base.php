<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

?>

<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class('sidebar-fixed header-fixed'); ?>>
    <!--[if IE]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
    <?php
      do_action('get_header');
      get_template_part('templates/header');
    ?>
    <div class="app-body" role="document">
        <div class="app-nav">
          <nav class="nav-primary">
            <?php
            $rows = get_field('menu_structure','options');

            if($rows){
              $x = 0;
              $y = 0;
            	echo '<ul id="filters" class="nav flex-column">';
            	foreach($rows as $row){
                $x++;
                $type = $row['navigation_type'];
                $label = $row['navigation_label'];

                echo '<li id="menu-item-'.$x.'" class="';
                if($type == "header"){
                  $y++;
                  echo 'nav-header nav-header-'.$y.' ';
                }
                echo 'menu-item menu-item-type-custom menu-item-object-custom menu-item-'.$x.'">';

                if($type == "link"){
                  echo '<a class="'.$type.'-'.$label.'" href="" data-filter=".'.$label.'">'.$label.'</a>';
                }else{
                  echo '<span>'.$label.'</span>';
                }
                echo '</li>';
            	}
            	echo '</ul>';
            }
            ?>
          </nav>
        </div>
        <main class="main">
          <div class="grid">
            <?php

            $args = array(
            	'post_type' => 'filaments',
            	'posts_per_page' => -1,
            	'orderby' => 'date',
              'order' => 'DESC'
            );

            $posts = get_posts( $args );
            foreach($posts as $post){
              //Variables
              $manufacturer = get_field('manufacturer');
              $type = get_field('type');
              $hotendTemp = get_field('hotend_temp');
              $bedTemp = get_field('bed_temp');
              $fan = get_field('fan');
              $speed = get_field('speed');
              $slicer = get_field('slicer');
              $color = get_field('color');

              echo '<div class="filament-item '.$type.' '.$manufacturer.'">';
                echo '<div class="card">';
                  echo '<div class="card-header">';
                    echo $manufacturer;
                    echo '<span class="badge badge-success float-right">'.$type.'</span>';
                    echo '<div class="card-body">';
                      echo '<p>Hotend Temp: '.$hotendTemp.'</p>';
                      echo '<p>Bed Temp: '.$bedTemp.'</p>';
                      echo '<p>Fan (On/Off): '.$fan.'</p>';
                      echo '<p>Speed: '.$speed.'</p>';
                      echo '<p>Slicer: '.$slicer.'</p>';
                      echo '<p>Color: '.$color.'</p>';
                    echo '</div>';
                  echo '</div>';
                echo '</div>';
              echo '</div>';
            }
            ?>

          </div>
        </main>
    </div>
    <?php
      do_action('get_footer');
      get_template_part('templates/footer');
      wp_footer();
    ?>
  </body>
</html>

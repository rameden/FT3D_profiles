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
            $categories = get_terms('category', array('hide_empty' => 0,));
            //init variables
            $subcategories = $categories;
            $x = 0;
            $y = 0;
            $z = 0;

            echo '<ul id="filters" class="nav flex-column">';
              echo '<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-0"><a class="" href="" data-filter="*">Show All</a></li>';
                foreach($categories as $category){
                  $x++;
                  // Only top level terms
                  if (0 != $category->parent){
                    continue;
                  }
                  // It is first level, display it
                  echo '<li id="menu-item-'.$x.'"><span class="nav-header">' . $category->name.'</span';
                  echo '<ul>';
                    $subsubcategories = $subcategories;
                    foreach($subcategories as $subcategory){
                    $y++;
                    // Only child terms
                    if ($category->term_id != $subcategory->parent){
                      continue;
                    }
                    echo '<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-'.$x.'"><a class="" href="" data-filter=".'.$subcategory->slug.'">'.$subcategory->name.'</a>';
                      $children = get_terms( $subcategory->taxonomy, array(
                      'parent'    => $subcategory->term_id,
                      'hide_empty' => false) );
                      if($children) {
                        echo '<ul class="nav-children">';
                        foreach($subsubcategories as $subsubcategory){
                          $z++;
                          // Only child terms
                          if ($subcategory->term_id != $subsubcategory->parent){
                            continue;
                          }
                          echo '<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-'.$z.'"><a class="" href="" data-filter=".'.$subsubcategory->slug.'">'.$subsubcategory->name.'</a></li>';
                          }
                        echo '</ul>';
                      }
                      echo '</li>';
                    }
                    echo '</li>';
                  echo '</ul>';
              }
            echo '</ul>';
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
              $categories = get_the_category($post->ID);;
              global $manufacturer;
              global $type;
              $hotendTemp = get_field('hotend_temp');
              $bedTemp = get_field('bed_temp');
              $fan = get_field('fan');
              $speed = get_field('speed');
              $slicer = get_field('slicer');
              $color = get_field('color');

              foreach($categories as $category){
                if($category->parent == 41){
                  $typeName = $category->name;
                  $typeSlug = $category->slug;
                }
                if($category->parent == 3){
                  $manufacturer = $category->name;
                }
              }

              echo '<div class="filament-item '.$typeSlug.' '.$manufacturer.'">';
                echo '<div class="card">';
                  echo '<div class="card-header">';
                    echo $manufacturer;
                    echo '<span class="badge badge-success float-right badge-'.$typeSlug.'">'.$typeName.'</span>';
                  echo '</div>';
                    echo '<div class="card-body">';
                      echo '<p><span class="semi-bold">Hotend Temp: </span>'.$hotendTemp.'&#8451;</p>';
                      echo '<p><span class="semi-bold">Bed Temp: </span>'.$bedTemp.'&#8451;</p>';
                      echo '<p><span class="semi-bold">Fan (On/Off): </span>'.$fan.'</p>';
                      echo '<p><span class="semi-bold">Speed: </span>'.$speed.' mm/s</p>';
                      echo '<p><span class="semi-bold">Slicer: </span>'.$slicer.'</p>';
                      echo '<p><span class="semi-bold">Color: </span>'.$color.'</p>';
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

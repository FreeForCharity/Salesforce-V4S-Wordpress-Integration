<?php
get_header(); ?>

<div id="primary" class="site-content" style="padding-top: 0px !important">
  <div id="content" role="main">
    <?php while ( have_posts() ) : the_post(); ?>
      <div class="iframe-content">
        <?php the_content(); ?>
      </div><!-- .iframe-content -->
    <?php endwhile; // end of the loop. ?>

  </div><!-- #content -->
</div><!-- #primary -->
<?php get_header();?>
<div id="main">
	<div id="content">
      <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
        <div class="entry">
          <h2><?php _e("Недавние 20 Записей", "voidy" ); ?></h2>
          <ul>
            <?php wp_get_archives('type=postbypost&limit=20'); ?>
          </ul>
          <h2><?php _e("по Категориям", "voidy" ); ?></h2>
          <ul>
            <?php wp_list_categories();?>
          </ul>
          <h2><?php _e("по Месяцам", "voidy" ); ?></h2>
          <ul>
            <?php wp_get_archives('type=monthly&show_post_count=true'); ?>
          </ul>
        </div>
        <p class="comments"></p>	          
      </div>      
	</div>
  <?php get_sidebar();?>
  <?php get_footer();?>
<?php get_header();?>
<div id="main">
	<div id="content">
	    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
        <div class="meta">
		<p>              
                <?php the_time('M d Y'); ?>

               <?php edit_post_link(); ?></p>
	</div>
	<div class="entry">
              <?php the_content(__('Продолжить чтение &#187;', "voidy" )); ?>
              <?php wp_link_pages(); ?>
      	</div>

            <p class="comments">
              <?php comments_popup_link(__('Нет ответов пока', "voidy" ), __('Один ответ до сих пор', "voidy" ), __('% ответов до сих пор', "voidy" ),'comments-link', 'Комментарии отключены на этот пост'); ?>
            </p>          
	        </div>
      <?php endwhile; else: ?>
          <p><?php _e('Извините, нет записей, удовлетворяющих вашим условиям.', "voidy" ); ?></p>
      <?php endif; ?>
      <p class="newer-older"><?php posts_nav_link(' ',__('&#171; Новые записи', "voidy" ),__('Старые записи &#187;', "voidy" )) ?></p>
	</div>
  <?php get_sidebar();?>
  <?php get_footer();
?>
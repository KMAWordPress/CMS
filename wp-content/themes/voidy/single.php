<?php get_header();?><?php

global $options, $option_values;
foreach ($options as $value) {
	if($value['id'] != "voidy_temp"){
	    if (empty($option_values[ $value['id']])) {
			$$value['id'] = $value['std'];
		} else {
			$$value['id'] = $option_values[ $value['id'] ]; 
		}
	}
}
?>


<div id="main">
	<div id="content">
	    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <h1 class="title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
            <div class="meta">
				<p>
				<?php the_time('M d Y'); ?>
				<?php if (!($voidy_hide_categories=="true")) { ?>
					<?php _e("Опубликовал", "voidy" ); ?> <?php the_author_posts_link() ?> <?php _e("в", "voidy" ); ?> <?php the_category(', ') ?>
				<?php } ?>
				<?php edit_post_link(); ?>
				</p>
			</div>
			<div class="entry">
              <?php the_content(__('Продолжить чтение &#187;', "voidy" )); ?>
              <?php wp_link_pages(); ?>
			  <?php if ($voidy_hide_tags && $voidy_hide_tags == "true") { ?>
				
			  <?php }else{ ?>
				<div class="tags"><?php the_tags(__('Метки: ', "voidy" ), ', ', '<br />'); ?></div>
			  <?php } ?>
      		</div>
			
            <p class="comments">
              <?php comments_popup_link(__('Нет ответов пока', "voidy" ), __('Один ответ до сих пор', "voidy" ), __('% ответов до сих пор', "voidy" ),'comments-link', 'Комментарии отключены на этот пост'); ?>
            </p>
	          <?php comments_template(); // Get wp-comments.php template ?>
	        </div>
      <?php endwhile; else: ?>
          <p><?php _e('Извините, нет записей, удовлетворяющих вашим условиям.', "voidy" ); ?></p>
      <?php endif; ?>

      
	</div>
  <?php get_sidebar();?>
  <?php get_footer();?>
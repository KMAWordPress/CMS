<?php get_header();?>
<div id="main">
	<div id="content">
      <?php if(have_posts()) : ?>
        <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
        <?php /* If this is a category archive */ if (is_category()) { ?>
        <h2 class="post-title">
          <?php  printf(__("Архив для '%s' категории", "voidy" ), single_cat_title('', False)) ; ?>
        </h2>

        <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
        <h2 class="post-title">
          <?php _e("Архив для: ", "voidy"); the_time('F jS, Y'); ?>
        </h2>

        <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
        <h2 class="post-title">
          <?php _e("Архив для: ", "voidy" ); the_time('F, Y'); ?>
        </h2>

        <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
        <h2 class="post-title">
          <?php _e("Архив для: ", "voidy" ); the_time('Y'); ?>
        </h2>

        <?php /* If this is a search */ } elseif (is_search()) { ?>
        <h2 class="post-title"><?php _e("Результаты Поиска", "voidy" ); ?></h2>

        <?php /* If this is an author archive */ } elseif (is_author()) { ?>
        <h2 class="post-title"><?php _e("Архив Автора", "voidy" ); ?></h2>

        <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
        <h2 class="post-title"><?php _e("Архивы Блога", "voidy" ); ?></h2>

        <?php } ?>
      <?php endif; ?>
	    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <div class="meta">
				<p>
					<?php the_time('M d Y'); ?>
					<?php _e("Опубликовал", "voidy" ); ?> <?php the_author_posts_link() ?> <?php _e("under", "voidy" ); ?> <?php the_category(', ') ?> <?php edit_post_link(); ?>
				</p>
			 </div>
			      <div class="entry">
              <?php the_content(__('Продолжить Чтение &#187;', "voidy" )); ?>
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
  <?php get_footer();?>
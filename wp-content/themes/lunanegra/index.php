<?php get_header(); ?>
<div class="page-wrapper index-php">  
	<div class="gdl-page-item">
		<div class="row">
			<div class="twelve columns">
                <div class="posts-home">
                    <?php
                    query_posts('category_name=home&post_status=publish');
        			if( have_posts() ):
        				while ( have_posts() ):
        					the_post();
        			?>
                            <div class="content-post" id="post-<?php echo get_the_id(); ?>">
                                <div class="title-post"><?php the_title(); ?></div>
                                <?php the_content(); ?>
                            </div>    
                    <?php
        				endwhile;
        			endif;
        			?>
                </div>
			</div>
            <?php get_sidebar('right'); ?>
            <div class="clear"></div>
		</div>
	</div>
	<div class="clear"></div>
</div>
<?php get_footer(); ?>
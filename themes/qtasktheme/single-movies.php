<?php
/*
Template Name: Movie Template
*/
get_header();
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        while (have_posts()) :
            the_post();
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                </header>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
                <div class="movie-title">
                    <?php echo esc_html(get_post_meta(get_the_ID(), 'movie_title', true)); ?>
                </div>
            </article>
        <?php
        endwhile;
        ?>
    </main>
</div>
<?php
get_footer();

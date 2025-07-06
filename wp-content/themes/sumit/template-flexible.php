<?php
/**
 * Template Name: Flexible Page
 */

get_header();
?>
<main id="main" class="site-main">
    <?php if (have_rows('page_sections')): ?> 
        <?php while (have_rows('page_sections')):
            the_row(); ?>
            <?php if (get_row_layout() == 'hero_section'): ?>
                <?php get_template_part('template-parts/sections/hero'); ?>

            <?php elseif (get_row_layout() == 'property_section'): ?>
                <?php get_template_part('template-parts/sections/property-list'); ?>

            <?php endif; ?>
        <?php endwhile; ?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
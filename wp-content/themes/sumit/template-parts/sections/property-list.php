<?php
$terms = get_terms(['taxonomy' => 'property_type', 'hide_empty' => true]);
$section_title = get_sub_field('section_title');
?>

<section class="property-list-section">
    <div class="container">
        <div class="property-tabs-header">
            <div class="title"><?php echo esc_html($section_title); ?></div>

            <ul class="property-tabs">
                <?php foreach ($terms as $term): ?>
                    <li data-term="<?php echo esc_attr($term->term_id); ?>" class="property-tab">
                        <?php echo esc_html($term->name); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div id="property-tab-results" class="property-results" data-offset="0"
            data-term="<?php echo esc_attr($terms[0]->term_id); ?>"></div>

        <div class="load-more-container">
            <div id="no-more-properties">No more properties found.</div>
            <button id="load-more-tabbed" class="load-more">Load More</button>
        </div>
    </div>
</section>
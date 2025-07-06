<?php
$post = get_post();
$property_id = get_field('property_id');
$address = get_field('address');
$status = get_field('status');
$price = get_field('price');
$beds = get_field('beds');
$baths = get_field('baths');
$area = get_field('area');
$image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
$gallery = get_field('image')['url'];
if ($gallery == '') {
    $gallery = get_template_directory_uri() . '/icons/dummy_home.jpg'; // Fallback image
}
?>

<div class="property-card" id="post-id-<?php echo esc_attr($post->ID); ?>">
    <div class="property-image" style="background-image: url('<?php echo esc_url($image); ?>')">
        <?php if ($status): ?>
            <span class="property-status"><?php echo esc_html($status); ?></span>
        <?php endif; ?>
        <img src="<?php echo esc_url($gallery); ?>" alt="Property Image" class="property-gallery-image">
    </div>

    <div class="property-content">
        <p class="property-id"><?php echo esc_html($property_id); ?></p>
        <p class="property-address"><?php echo esc_html($address); ?></p>

        <ul class="property-features">
            <li><img src="<?php echo get_template_directory_uri(); ?>/icons/bed.svg" alt="Beds">
                <?php echo $beds; ?> Beds</li>
            <li><img src="<?php echo get_template_directory_uri(); ?>/icons/bath.svg" alt="Baths">
                <?php echo $baths; ?> Baths</li>
            <li><img src="<?php echo get_template_directory_uri(); ?>/icons/area.svg" alt="SqFt">
                <?php echo $area; ?> Sq.Ft.</li>
        </ul>

        <p class="property-price">$<?php echo number_format($price); ?></p>
    </div>
</div>
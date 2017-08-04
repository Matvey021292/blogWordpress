<section>
    <div class="container ">
    <?php  $gallerys = get_post_meta($post->ID, 'main_gallery_list', true); ?>
        <div id="grid-gallery" class="gridpage-gallery">
            <section class="gridpage-wrap">
                <ul class="gridpage">
                    <li class="gridpage-sizer"></li><!-- for Masonry column width -->
                    <?php foreach ($gallerys as $gallery) { ?>
                    <li>
                        <figure>
                            <img src="<?php echo $gallery[main_gallery_list_upload] ?>" alt="img01"/>
                            <figcaption><h3><?php echo $gallery[main_gallery_list_text] ?></h3></figcaption>
                        </figure>
                    </li>
                    <?php };
                    ?>
                </ul>
            </section><!-- // gridpage-wrap -->
            <section class="slideshow">
                <ul>
                    <?php foreach ($gallerys as $gallery) { ?>
                    <li>
                        <figure>
                            <figcaption>
                                <figcaption><h3><?php echo $gallery[main_gallery_list_text] ?></h3></figcaption>
                            </figcaption>
                            <img src="<?php echo $gallery[main_gallery_list_upload] ?>" alt="img01"/>
                        </figure>
                    </li>
                    <?php };
                    ?>
                </ul>
                <div class="nav">
                    <span class="icon nav-prev"></span>
                    <span class="icon nav-next"></span>
                    <span class="icon nav-close"></span>
                </div>
                <div class="info-keys icon">Navigate with arrow keys</div>
            </section><!-- // slideshow -->
        </div><!-- // gridpage-gallery -->
    </div>
</section>
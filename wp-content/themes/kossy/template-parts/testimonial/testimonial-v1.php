<?php
   $job = get_post_meta( get_the_ID(), 'apus_testimonial_job', true );
   $link = get_post_meta( get_the_ID(), 'apus_testimonial_link', true );
?>
<div class="testimonial-body">
  <div class="flex-middle">
    <div class="row">
      <div class="col-lg-3 col-sm-4 col-md-4 col-xs-12">
        <div class="image">
           <?php the_post_thumbnail('widget'); ?>
        </div>
      </div>
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <div class="info">
            <div class="icon-test">
              <i class="icon_quotations text-theme"></i>
            </div>
            <div class="description">
              <?php the_content(); ?>      
            </div>
            <?php if (!empty($link)) { ?>
              <h3 class="name-client"><a href="<?php echo esc_url_raw($link); ?>"><?php the_title(); ?></a></h3>
            <?php } else { ?>
              <h3 class="name-client"><?php the_title(); ?></h3>
            <?php } ?>
            <div class="job text-theme"><?php echo sprintf(__('%s', 'kossy'), $job); ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
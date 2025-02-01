<?php
    $prg_page_url = sprintf('?page=%s', 'portfolio-responsive-gallery');
    $add_new_url = sprintf('?page=%s&action=%s', 'portfolio-responsive-gallery', 'add');
?>

<div class="wrap">
    <div class="ays-portfolio-heart-beat-main-heading ays-portfolio-heart-beat-main-heading-container">
        <h1 class="ays-portfolio-responsive-prg-wrapper ays_heart_beat">
            <?php echo __(esc_html(get_admin_page_title()),$this->plugin_name); ?> <i class="fa fa_heart_o animated"></i>
        </h1>
    </div>
    <div class="ays-prg-prg-main">
        <h2>
            <?php 
                echo sprintf( 
                    __( "How to create a simple portfolio in 3 steps with the help of the %s Portfolio Responsive Gallery %s plugin.", $this->plugin_name ),
                    '<strong>',
                    '</strong>'
                ); 
            ?>
        </h2>
        <fieldset>
            <div class="ays-prg-ol-container">
                <ol>
                    <li>
                        <?php 
                            echo sprintf( 
                                __( "Go to the %s Portfolios %s page and build your first Portfolio Responsive Gallery by clicking on the %s Add New %s button.", $this->plugin_name ),
                                '<a href="'. $prg_page_url .'" target="_blank">',
                                '</a>',
                                '<a href="'. $add_new_url .'" target="_blank">',
                                '</a>'
                            ); 
                        ?>
                    </li>
                    <li>
                        <?php echo __( "Fill out the information by adding a title, projects and so on.", $this->plugin_name ); ?>
                    </li>
                    <li>
                        <?php 
                            echo sprintf( 
                                __( "Copy the %s shortcode %s of the Portfolio Responsive Gallery and paste it into any post․", $this->plugin_name ),
                                '<strong>',
                                '</strong>'
                            ); 
                        ?> 
                    </li>
                </ol>
            </div>
            <div class="ays-prg-p-container">
                <p><?php echo __("Congrats! You have already created your first Portfolio Responsive Gallery." , $this->plugin_name); ?></p>
            </div>
        </fieldset>
    </div>  
    <br>

    <div class="ays-prg-community-wrap">
        <div class="ays-prg-community-title">
            <h4><?php echo __( "Community", $this->plugin_name ); ?></h4>
        </div>
        <div class="ays-prg-community-container">
            <div class="ays-prg-community-item">
                <a href="https://www.youtube.com/channel/UC-1vioc90xaKjE7stq30wmA" target="_blank" class="ays-prg-community-item-cover" style="color: #ff0000;background-color: rgba(253, 38, 38, 0.1);">
                    <img class="ays-prg-community-item-img" src="<?php echo AYS_PRG_ADMIN_URL; ?>/images/youtube.png">
                </a>
                <h3 class="ays-prg-community-item-title"><?php echo __( "YouTube community", $this->plugin_name ); ?></h3>
                <p class="ays-prg-community-item-desc"></p>
                <div class="ays-prg-community-item-footer">
                    <a href="https://www.youtube.com/channel/UC-1vioc90xaKjE7stq30wmA" target="_blank" class="button"><?php echo __( "Subscribe", $this->plugin_name ); ?></a>
                </div>
            </div>
            <div class="ays-prg-community-item">
                <a href="https://wordpress.org/support/plugin/portfolio-responsive-gallery/" target="_blank" class="ays-prg-community-item-cover" style="color: #0073aa;background-color: rgb(220, 220, 220);">
                    <img class="ays-prg-community-item-img" src="<?php echo AYS_PRG_ADMIN_URL; ?>/images/wordpress.png">
                </a>
                <h3 class="ays-prg-community-item-title"><?php echo __( "Free support", $this->plugin_name ); ?></h3>
                <p class="ays-prg-community-item-desc"></p>
                <div class="ays-prg-community-item-footer">
                    <a href="https://wordpress.org/support/plugin/portfolio-responsive-gallery/" target="_blank" class="button"><?php echo __( "Join", $this->plugin_name ); ?></a>
                </div>
            </div>
            <div class="ays-prg-community-item">
                <a href="https://ays-pro.com/contact" target="_blank" class="ays-prg-community-item-cover" style="color: #ff0000;background-color: rgba(0, 115, 170, 0.22);">
                    <img class="ays-prg-community-item-img" src="<?php echo AYS_PRG_ADMIN_URL; ?>/images/logo_final.png">
                </a>
                <h3 class="ays-prg-community-item-title"><?php echo __( "Premium support", $this->plugin_name ); ?></h3>
                <p class="ays-prg-community-item-desc"></p>
                <div class="ays-prg-community-item-footer">
                    <a href="https://ays-pro.com/contact" target="_blank" class="button"><?php echo __( "Contact", $this->plugin_name ); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var acc = document.getElementsByClassName("ays-prg-asked-question__header");
    var i;
    for (i = 0; i < acc.length; i++) {
      acc[i].addEventListener("click", function() {
        
        var panel = this.nextElementSibling;
        
        
        if (panel.style.maxHeight) {
          panel.style.maxHeight = null;
          this.children[1].children[0].style.transform="rotate(0deg)";
        } else {
          panel.style.maxHeight = panel.scrollHeight + "px";
          this.children[1].children[0].style.transform="rotate(180deg)";
        } 
      });
    }
</script>

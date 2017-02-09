<?php
//s echo "<pre>", var_dump($data);
global $rm_env_requirements;
?>

<?php if (!($rm_env_requirements & RM_REQ_EXT_ZIP)){ ?>
 <div class="shortcode_notification"><p class="rm-notice-para"><?php echo RM_UI_Strings::get('RM_ERROR_EXTENSION_ZIP');?></p></div>
 <?php } ?>

<div class="rmagic">
    <div class="operationsbar">
        <!-- <div class="icons">
            <img alt="" src="<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . 'images/supporticon.png'; ?>">>
        </div> -->
        <div class="rmtitle"><?php echo RM_UI_Strings::get('TITLE_ATTACHMENT_PAGE'); ?></div>
        <div class="nav">
                <ul>  
                    <li onclick="window.history.back()"><a href="javascript:void(0)"><?php echo RM_UI_Strings::get("LABEL_BACK"); ?></a></li>
                </ul>
    </div>
    </div>
    
        <!-- Plugin gold and silver edition banner-->
    <div class="rm-upgrade-note-gold">
        <div class="rm-banner-title">View and Download form attachments at a single place by upgrading<img src="<?php echo RM_IMG_URL.'logo.png'?>"> </div>
        <div class="rm-banner-subtitle">Choose from two powerful extension bundles</div>
        <div class="rm-banner-box"><a href="https://registrationmagic.com/buy-silver-bundle/" target="blank"><img src="<?php echo RM_IMG_URL.'silver-logo.png'?>"></a>

        </div>
        <div class="rm-banner-box"><a href="https://registrationmagic.com/buy-gold-bundle/" target="blank"><img src="<?php echo RM_IMG_URL.'gold-logo.png'?>"></a>

        </div>
    </div>

    </div>

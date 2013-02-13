<div class="wrap">
    <div id="icon-options-general" class="icon32"><br /></div> 
    <h2>General Options</h2>
    <h2 class="nav-tab-wrapper">
        <a href="#facebook" class="nav-tab nav-tab-active">Facebook</a>
        <a href="#youtube" class="nav-tab">YouTube</a>
        <a href="#flickr" class="nav-tab">Flickr</a>
        <a href="#instagram" class="nav-tab">Instagram</a>
        
    </h2>
    
    <div class="metabox-holder nav-tab-container-wrapper">
        <div id="facebook" class="nav-tab-container nav-tab-container-active">
            <div class="postbox">
                <h3>Facebook</h3>
                <form class="smi-form" method="POST">
                    <input type="hidden" name="section" value="facebook" />
                    <div class="smi-row-input">
                        <?php 
                        $facebookSettings = isset($facebookSettings) ? $facebookSettings : array();
                        foreach($facebookSettings as $setting):
                        ?>
                            <h4 class="smi-title"><?php echo $setting['title']; ?></h4>
                            <input class="regular-text" name="<?php echo $setting['key']; ?>" value="<?php echo $setting['value']; ?>" />
                        <?php endforeach; ?>
                    </div>

                    <div class="smi-row-button">
                        <button class="button-primary">Save Options</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div id="youtube" class="nav-tab-container">
            <div class="postbox">
                <h3>YouTube</h3>
                <form class="smi-form" method="POST">
                    <input type="hidden" name="section" value="youtube" />
                    <div class="smi-row-input">
                        <?php 
                        $youtubeSettings = isset($youtubeSettings) ? $youtubeSettings : array();
                        foreach($youtubeSettings as $setting):
                        ?>
                            <h4 class="smi-title"><?php echo $setting['title']; ?></h4>
                            <input class="regular-text" name="<?php echo $setting['key']; ?>" value="<?php echo $setting['value']; ?>" />
                        <?php endforeach; ?>
                    </div>

                    <div class="smi-row-button">
                        <button class="button-primary">Save Options</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div id="flickr" class="nav-tab-container">
            <div class="postbox">
                <h3>Flickr</h3>
                <form class="smi-form" method="POST">
                    <input type="hidden" name="section" value="flickr" />
                    <div class="smi-row-input">
                        <?php 
                        $flickrSettings = isset($flickrSettings) ? $flickrSettings : array();
                        foreach($flickrSettings as $setting):
                        ?>
                            <h4 class="smi-title"><?php echo $setting['title']; ?></h4>
                            <input class="regular-text" name="<?php echo $setting['key']; ?>" value="<?php echo $setting['value']; ?>" />
                        <?php endforeach; ?>
                    </div>

                    <div class="smi-row-button">
                        <button class="button-primary">Save Options</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div id="instagram" class="nav-tab-container">
            <div class="postbox">
                <h3>Instagram</h3>
                <form class="smi-form" method="POST">
                    <input type="hidden" name="section" value="instagram" />
                    <div class="smi-row-input">
                        <?php 
                        $instagramSettings = isset($instagramSettings) ? $instagramSettings : array();
                        foreach($instagramSettings as $setting):
                        ?>
                            <h4 class="smi-title"><?php echo $setting['title']; ?></h4>
                            <input class="regular-text" name="<?php echo $setting['key']; ?>" value="<?php echo $setting['value']; ?>" />
                        <?php endforeach; ?>
                    </div>

                    <div class="smi-row-button">
                        <button class="button-primary">Save Options</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>
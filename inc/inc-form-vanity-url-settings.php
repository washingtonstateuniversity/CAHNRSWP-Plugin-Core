<?php wp_nonce_field('set_redirect','redirect_nonce'); ?> 
<div id="vanityurl-redirect">
    <div class="metabox-content-wrapper">
        <div class="metabox-field-set redirect">
            <div class="metabox-field-set-inner">
                <label for="vanityurl_redirect">Redirect Address </label>
                <input id="vanityurl_redirect" type="text" name="_vanity_url[vanityurl_redirect]" value="<?php echo $this->model->vanityurl_redirect ;?>">
                <div class="input-description">
                    <b>***NOTE:</b> The URL must begin with http:// or https:// - Example http://www.google.com
                </div>
            </div>
        </div>
        <div class="metabox-field-set redirect-data">
            <div class="metabox-field-set-inner">
                <label for="vanityurl_redirect">Redirect Owner Email </label>
                <input id="vanityurl_redirect_owner" type="text" name="_vanity_url[vanityurl_redirect_owner]" value="<?php echo $this->model->vanityurl_redirect_owner ;?>">
                <div class="input-description">
                    Email address of the person (content owner) to contact if changes need to be made.
                </div>
            </div>
        </div>
    </div>
</div>
<div id="vanityurl-campaign">
    <div class="metabox-content-wrapper">
        <div class="input-description-note">
                    <b>***NOTE:</b> All spaces will be replaced with dashes. Use only URL friendly characters with the exception of the following (do not use these) “&”, ”?”, ”=”. 
                </div>
        <div class="first metabox-field-set">
            <div class="metabox-field-set-inner">
            <!-- Next Field Set -->
            <label for="vanityurl_camp_name">Campaign Name <em>* Required</em></label>
            <input id="vanityurl_camp_name" type="text" name="_vanity_url[vanityurl_camp_name]" value="<?php echo $this->model->vanityurl_camp_name;?>">
            <div class="input-description">Used to identify a specific strategic campaign such as a reoccurring newsletter, series of emails, conference event, or other promotion.</div>
            <!-- Next Field Set -->
            <label for="vanityurl_camp_source">Campaign Source <em>* Required</em></label>
            <input id="vanityurl_camp_source" type="text" name="_vanity_url[vanityurl_camp_source]" value="<?php echo $this->model->vanityurl_camp_source;?>">
            <div class="input-description">Used to identify the source of your traffic such as: search engine, newsletter, or other referral.</div>
            </div>
        </div><div class="metabox-field-set">
            <div class="metabox-field-set-inner">
            <!-- Next Field Set -->
            <label for="vanityurl_camp_medium">Campaign Medium <em>* Required</em></label>
            <select name="_vanity_url[vanityurl_camp_medium]">
                <option value="">Not Set</option>
                <option value="email" <?php selected( $this->model->vanityurl_camp_medium , '' );?>>Email</option>
                <option value="direct-mail" <?php selected( $this->model->vanityurl_camp_medium , 'direct-mail' );?>>Direct Mail</option>
                <option value="display" <?php selected( $this->model->vanityurl_camp_medium , 'display' );?>>Banner/Display <em>(*display)</em></option>
                <option value="social" <?php selected( $this->model->vanityurl_camp_medium , 'social' );?>>Social</option>
                <option value="print" <?php selected( $this->model->vanityurl_camp_medium , 'print' );?>>Print</option>
                <option value="cpc" <?php selected( $this->model->vanityurl_camp_medium , 'cpc' );?>>CPC/PPC <em>(*cpc)</em></option>
                <option value="ppc" <?php selected( $this->model->vanityurl_camp_medium , 'ppc' );?>>PPC</option>
            </select>
            <div class="input-description">Used to identify the medium the link was used upon such as: email, CPC, or other method of sharing.</div>
            <!-- Next Field Set -->
            <label for="vanityurl_camp_term">Campaign Term <em>* Optional</em></label>
            <input id="vanityurl_camp_term" type="text" name="_vanity_url[vanityurl_camp_term]" value="<?php echo $this->model->vanityurl_camp_term;?>">
            <div class="input-description">Optional parameter suggested for paid search to identify keywords for your ad.</div>
            </div>
        </div><div class="last metabox-field-set">
            <div class="metabox-field-set-inner">
            <!-- Next Field Set -->
            <label for="vanityurl_camp_content">Campaign Content <em>* Optional</em></label>
            <input id="vanityurl_camp_content" type="text" name="_vanity_url[vanityurl_camp_content]" value="<?php echo $this->model->vanityurl_camp_content;?>">
            <div class="input-description">Used to differentiate similar content, or links within the same ad. For example, if you have two call-to-action links within the same email message, you can use utm_content and set different values for each so you can tell which version is more effective.</div>
                </div>
        </div>
    </div>
</div>
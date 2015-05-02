<?php require_once WPCEF_PLUGIN_DIR . '/helpers.php'; ?>

<form id="cool-eform" action="<?php echo cef_get_current_url(); ?>" method="post">

    <?php $fields = get_option( WPCEF_SETTINGS_FIELDS ); ?>

    <?php if ( isset( $this->errors['form'] ) ): ?>
        <p id="cef-form-error" class="error"><?php echo $this->errors['form'] ?></p>
    <?php endif; ?>

    <?php if ( cef_is_field_used( $fields, 'name' ) ): ?>
        <div>
            <label id="cef-name-label" for="cef-name" class="desc">
                <?php _e( 'Name', 'cef' ) ?> <sup><?php cef_required( $fields, 'name' ) ?></sup>
            </label>
            <div>
                <input id="cef-name" name="cef-name" type="text" class="field text" value="<?php echo cef_get_param_value( 'cef-name' ) ?>" <?php cef_required( $fields, 'name', 'required' ) ?>>
                <?php if ( isset( $this->errors['name'] ) ): ?>
                    <div id="cef-name-error" class="error"><?php echo $this->errors['name'] ?></div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ( cef_is_field_used( $fields, 'email' ) ): ?>
        <div>
            <label id="cef-email-label" for="cef-email" class="desc">
                <?php _e( 'Email', 'cef' ) ?> <sup><?php cef_required( $fields, 'email' ) ?></sup>
            </label>
            <div>
                <input id="cef-email" name="cef-email" type="email" class="field email" value="<?php echo cef_get_param_value( 'cef-email' ) ?>" <?php cef_required( $fields, 'email', 'required' ) ?>>
                <?php if ( isset( $this->errors['email'] ) ): ?>
                    <div id="cef-email-error" class="error"><?php echo $this->errors['email'] ?></div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ( cef_is_field_used( $fields, 'phone' ) ): ?>
        <div>
            <label id="cef-phone-label" for="cef-phone" class="desc">
                <?php _e( 'Phone', 'cef' ) ?> <sup><?php cef_required( $fields, 'phone' ) ?></sup>
            </label>
            <div>
                <input id="cef-phone" name="cef-phone" type="text" class="field phone" value="<?php echo cef_get_param_value( 'cef-phone' ) ?>" <?php cef_required( $fields, 'phone', 'required' ) ?>>
                <?php if ( isset( $this->errors['phone'] ) ): ?>
                    <div id="cef-phone-error" class="error"><?php echo $this->errors['phone'] ?></div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ( cef_is_field_used( $fields, 'subject' ) ): ?>
        <div>
            <label id="cef-subject-label" for="cef-subject" class="desc">
                <?php _e( 'Subject', 'cef' ) ?> <sup><?php cef_required( $fields, 'subject' ) ?></sup>
            </label>
            <div>
                <input id="cef-subject" name="cef-subject" type="text" class="field text" value="<?php echo cef_get_param_value( 'cef-subject' ) ?>" <?php cef_required( $fields, 'subject', 'required' ) ?>>
                <?php if ( isset( $this->errors['subject'] ) ): ?>
                    <div id="cef-subject-error" class="error"><?php echo $this->errors['subject'] ?></div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ( cef_is_field_used( $fields, 'message' ) ): ?>
        <div>
            <label id="cef-message-label" for="cef-message" class="desc">
                <?php _e( 'Message', 'cef' ) ?> <sup><?php cef_required( $fields, 'message' ) ?></sup>
            </label>
            <div>
                <textarea id="cef-message" name="cef-message" class="field textarea" spellcheck="true" rows="10" cols="50" <?php cef_required( $fields, 'message', 'required' ) ?>><?php echo cef_get_param_value( 'cef-message' ) ?></textarea>
                <?php if ( isset( $this->errors['message'] ) ): ?>
                    <div id="cef-message-error" class="error"><?php echo $this->errors['message'] ?></div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ( cef_is_field_used( $fields, 'antispam' ) ): ?>

        <?php $num1 = rand( 1, 10 ); ?>
        <?php $num2 = rand( 1, 10 ); ?>

        <div>
            <label id="cef-antispam-label" for="cef-antispam" class="desc">
                <?php echo $num1 . ' + ' . $num2 ?> <sup><?php cef_required( $fields, 'antispam' ) ?></sup>
            </label>
            <div>
                <input id="cef-antispam-expected" name="cef-antispam-expected" type="hidden" class="field text" value="<?php echo $num1 + $num2 ?>">
                <input id="cef-antispam" name="cef-antispam" type="text" class="field antispam" value="<?php echo cef_get_param_value( 'cef-antispam' ) ?>" <?php cef_required( $fields, 'antispam', 'required' ) ?>>
                <?php if ( isset( $this->errors['antispam'] ) ): ?>
                    <div id="cef-antispam-error" class="error"><?php echo $this->errors['antispam'] ?></div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <div>
        <div>
            <input id="cef-sent" name="cef-sent" type="submit" class="button" value="<?php _e( 'Send', 'cef' ); ?>">
            <input id="cef-referrer" name="cef-referrer" type="hidden" value="<?php echo cef_get_current_url(); ?>">
            <?php wp_nonce_field( 'sent', 'cef-nonce', false ); ?>
        </div>
    </div>

</form>

<script>
    jQuery.extend(jQuery.validator.messages, {
        required: "<?php _e ( 'This field is required.', 'cef' ); ?>",
        email: "<?php _e( 'Please enter a valid email address.', 'cef' ); ?>"
    });

    jQuery('#cool-eform').validate({
        errorElement: "div",
        errorClass: "error"
    });
</script>

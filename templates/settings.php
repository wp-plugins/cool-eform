<div class="wrap">
    <h2><?php _e( 'eForm Settings', 'cef' ) ?></h2>
    <form action="options.php" method="post">
        <?php settings_fields( 'cool_eform' ); ?>

        <h3 class="title"><?php _e( 'General', 'cef' ) ?></h3>
        <p><?php _e( 'The settings listed below determine the address to send the email to or the default subject of the email.', 'cef' ); ?></p>

        <?php $general = get_option( WPCEF_SETTINGS_GENERAL ); ?>

        <table class="form-table">
            <tr>
                <th scope="row"><label for="from_name"><?php _e( '"From" Name', 'cef' ) ?></label></th>
                <td>
                    <input id="from_name" name="cef_general[from_name]" type="text" class="regular-text" value="<?php echo $general['from_name']; ?>">
                    <p class="description"><?php _e( 'Email will appear to be from this name.', 'cef' ); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="from_address"><?php _e( '"From" Address', 'cef' ) ?></label></th>
                <td>
                    <input id="from_address" name="cef_general[from_address]" type="text" class="regular-text" value="<?php echo $general['from_address']; ?>">
                    <p class="description"><?php _e( 'Email will appear to be from this email address.', 'cef' ); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="to_address"><?php _e( '"To" Address', 'cef' ) ?></label></th>
                <td>
                    <input id="to_address" name="cef_general[to_address]" type="text" class="regular-text" value="<?php echo $general['to_address']; ?>">
                    <p class="description"><?php _e( 'Email will be send to this email address.', 'cef' ); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="subject"><?php _e( 'Subject', 'cef' ) ?></label></th>
                <td>
                    <input id="subject" name="cef_general[subject]" type="text" class="regular-text" value="<?php echo $general['subject']; ?>">
                    <p class="description"><?php _e( 'If the subject field is not selected or is empty, the email will have this subject.', 'cef' ); ?></p>
                </td>
            </tr>
        </table>

        <h3 class="title"><?php _e( 'Fields', 'cef' ) ?></h3>
        <p><?php _e( 'The list of available fields for the form.', 'cef' ); ?></p>

        <?php $fields = get_option( WPCEF_SETTINGS_FIELDS ); ?>

        <table class="form-table">
            <tr>
                <th scope="col"><?php _e( 'Fields', 'cef' ) ?></th>
                <th scope="col"><?php _e( 'Used', 'cef' ) ?></th>
                <th scope="col"><?php _e( 'Mandatory', 'cef' ) ?></th>
            </tr>
            <tr>
                <th scope="row"><?php _e( 'Name', 'cef' ) ?></th>
                <td>
                    <input id="field_name_used" name="cef_fields[name][used]" type="checkbox" value="1" <?php checked( $fields['name']['used'], 1 ); ?>>
                </td>
                <td>
                    <input id="field_name_mandatory" name="cef_fields[name][mandatory]" type="checkbox" value="1" <?php checked( $fields['name']['mandatory'], 1 ); ?>>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e( 'Email', 'cef' ) ?></th>
                <td>
                    <input id="field_email_used" name="cef_fields[email][used]" type="checkbox" value="1" <?php checked( $fields['email']['used'], 1 ); ?>>
                </td>
                <td>
                    <input id="field_email_mandatory" name="cef_fields[email][mandatory]" type="checkbox" value="1" <?php checked( $fields['email']['mandatory'], 1 ); ?>>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e( 'Phone', 'cef' ) ?></th>
                <td>
                    <input id="field_phone_used" name="cef_fields[phone][used]" type="checkbox" value="1" <?php checked( $fields['phone']['used'], 1 ); ?>>
                </td>
                <td>
                    <input id="field_phone_mandatory" name="cef_fields[phone][mandatory]" type="checkbox" value="1" <?php checked( $fields['phone']['mandatory'], 1 ); ?>>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e( 'Subject', 'cef' ) ?></th>
                <td>
                    <input id="field_subject_used" name="cef_fields[subject][used]" type="checkbox" value="1" <?php checked( $fields['subject']['used'], 1 ); ?>>
                </td>
                <td>
                    <input id="field_subject_mandatory" name="cef_fields[subject][mandatory]" type="checkbox" value="1" <?php checked( $fields['subject']['mandatory'], 1 ); ?>>
                </td>
            <tr>
                <th scope="row"><?php _e( 'Message', 'cef' ) ?></th>
                <td>
                    <input id="field_message_used" name="cef_fields[message][used]" type="checkbox" value="1" checked="checked" disabled="disabled">
                    <input name="cef_fields[message][used]" type="hidden" value="1">
                </td>
                <td>
                    <input id="field_message_mandatory" name="cef_fields[message][mandatory]" type="checkbox" value="1" checked="checked" disabled="disabled">
                    <input name="cef_fields[message][mandatory]" type="hidden" value="1">
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e( 'Anti Spam', 'cef' ) ?></th>
                <td>
                    <input id="field_antispam_used" name="cef_fields[antispam][used]" type="checkbox" value="1" <?php checked( $fields['antispam']['used'], 1 ); ?>>
                </td>
                <td>
                    <input id="field_antispam_mandatory" name="cef_fields[antispam][mandatory]" type="checkbox" value="1" checked="checked" disabled="disabled">
                    <input name="cef_fields[antispam][mandatory]" type="hidden" value="1">
                </td>
            </tr>
        </table>

        <?php submit_button(); ?>
    </form>
</div>

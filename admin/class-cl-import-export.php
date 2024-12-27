<?php

class ContactListImportExport {
    public function register_import_page() {
        add_submenu_page(
            'edit.php?post_type=' . esc_attr( CONTACT_LIST_CPT ),
            sanitize_text_field( __( 'Import contacts', 'contact-list' ) ),
            sanitize_text_field( __( 'Import contacts', 'contact-list' ) ),
            'manage_options',
            'contact-list-import',
            [$this, 'register_import_page_callback']
        );
    }

    public function register_export_page() {
        add_submenu_page(
            'edit.php?post_type=' . esc_attr( CONTACT_LIST_CPT ),
            sanitize_text_field( __( 'Export contacts', 'contact-list' ) ),
            sanitize_text_field( __( 'Export contacts', 'contact-list' ) ),
            'manage_options',
            'contact-list-export',
            [$this, 'register_export_page_callback']
        );
    }

    public function trigger_import(
        $fileName,
        $cron,
        $update_by_email,
        $ignore_first_line,
        $delete_existing_contacts
    ) {
        $start_import = ContactListImport::importFromFile__premium_only(
            $fileName,
            $cron,
            $update_by_email,
            $ignore_first_line,
            $delete_existing_contacts
        );
    }

    public function register_import_page_callback() {
        $s = get_option( 'contact_list_settings' );
        $override_import_fields = 0;
        ?>

    <div class="wrap contact-list-admin-page">

      <h1 style="display: none;"><?php 
        echo esc_html__( 'Import contacts', 'contact-list' );
        ?></h1>

      <?php 
        ?>

      <?php 
        if ( ContactListHelpers::isPremium() == 0 ) {
            ?>

        <p>
          <?php 
            echo esc_html__( 'You may import contacts from a csv file using this form.', 'contact-list' );
            ?>
        </p>

        <p>
          <?php 
            echo esc_html__( 'There should be one contact per row, columns separated by a comma or a semicolon (can be changed in the settings).', 'contact-list' );
            ?>
        </p>

        <hr class="style-one" />

        <?php 
            echo ContactListHelpers::proFeatureMarkup();
            ?>

        <hr class="style-one" />

        <h2><?php 
            echo esc_html__( 'The columns should be in this order (can be changed in the settings):', 'contact-list' );
            ?></h2>

        <ol>

          <?php 
            $fields = ContactListContactHelpers::get_original_import_fields();
            ?>

          <?php 
            foreach ( $fields as $field ) {
                ?>

            <?php 
                $title = ContactListContactHelpers::getTitleByName( $field );
                ?>

            <?php 
                if ( $title ) {
                    ?>

              <li><?php 
                    echo esc_html( $title );
                    ?></li>

            <?php 
                } else {
                    ?>

              <li style="font-weight: 700;"><?php 
                    echo esc_html( $field );
                    ?></li>

            <?php 
                }
                ?>

          <?php 
            }
            ?>

        </ol>

      <?php 
        }
        ?>

    </div>
    <?php 
    }

    /**
     * Save a chunk of data to a temporary file.
     */
    public static function save_chunk_to_file(
        $chunk,
        $original_file_name,
        $chunk_index,
        $chunk_prefix
    ) {
        $upload_dir = wp_upload_dir();
        $chunk_file = $upload_dir['path'] . '/' . $chunk_prefix . '_chunk-' . $chunk_index . '_' . basename( $original_file_name );
        $handle = fopen( $chunk_file, 'w' );
        foreach ( $chunk as $row ) {
            fputcsv( $handle, $row );
        }
        fclose( $handle );
        ContactListAdminImportLog::write_log( 'Chunk file created: ' . $chunk_file );
        return $chunk_file;
    }

    public function register_export_page_callback() {
        $s = get_option( 'contact_list_settings' );
        $override_export_fields = 0;
        ?>

    <div class="wrap contact-list-admin-page">

      <h1 style="display: none;"><?php 
        echo esc_html__( 'Export contacts', 'contact-list' );
        ?></h1>

      <?php 
        ?>

      <?php 
        if ( ContactListHelpers::isPremium() == 0 ) {
            ?>

        <p>
          <?php 
            echo esc_html__( 'You may export contacts to a csv file.', 'contact-list' );
            ?>
        </p>

        <p>
          <?php 
            echo esc_html__( 'There will be one contact per row, columns separated by a comma or a semicolon (can be changed in the settings).', 'contact-list' );
            ?>
        </p>

        <hr class="style-one" />

        <?php 
            echo ContactListHelpers::proFeatureMarkup();
            ?>

        <hr class="style-one" />

        <h2><?php 
            echo esc_html__( 'The columns are in this order (default order, can be changed in the settings):', 'contact-list' );
            ?></h2>

        <ol>

          <?php 
            $fields = ContactListContactHelpers::get_original_import_fields();
            ?>

          <?php 
            foreach ( $fields as $field ) {
                ?>

            <?php 
                $title = ContactListContactHelpers::getTitleByName( $field );
                ?>

            <?php 
                if ( $title ) {
                    ?>

              <li><?php 
                    echo esc_html( $title );
                    ?></li>

            <?php 
                } else {
                    ?>

              <li style="font-weight: 700;"><?php 
                    echo esc_html( $field );
                    ?></li>

            <?php 
                }
                ?>

          <?php 
            }
            ?>

        </ol>

      <?php 
        }
        ?>

    </div>
    <?php 
    }

}

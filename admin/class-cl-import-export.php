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

    public function register_import_page_callback() {
        $s = get_option( 'contact_list_settings' );
        $override_import_fields = 0;
        ?>

    <div class="wrap contact-list-admin-page">

        <h1><?php 
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

    public function register_export_page_callback() {
        $s = get_option( 'contact_list_settings' );
        $override_export_fields = 0;
        ?>

    <div class="wrap contact-list-admin-page">

        <h1><?php 
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

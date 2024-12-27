<?php

class ContactListImport {
    public function set_upload_dir( $dir ) {
        $full_path_new = realpath( $dir['basedir'] ) . '/contact-list/_import-temp';
        if ( !file_exists( $full_path_new ) ) {
            mkdir( $full_path_new );
        }
        return array(
            'path'   => realpath( $dir['basedir'] ) . '/contact-list/_import-temp',
            'url'    => $dir['baseurl'] . '/contact-list/_import-temp',
            'subdir' => '/contact-list/_import-temp',
        ) + $dir;
    }

}

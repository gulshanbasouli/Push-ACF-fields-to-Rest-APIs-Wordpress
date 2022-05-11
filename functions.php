<?php

Through the following code, you will be able to expose page and your custom postypes ACF fields in the wordpress REST API and access them inside the ACF object.

You can obviously customise the postypes to exclude or to include in the arrays: $postypes_to_exclude and $extra_postypes_to_include.

//Push ACF fields to Rest APIs Wordpress

function lf_crt_ACF_meta_in_appdev_REST() {
    $postypes_to_exclude = ['acf-field-group','acf-field'];
    $extra_postypes_to_include = ["post"];
    $post_types = array_diff(get_post_types(["_builtin" => false], 'names'),$postypes_to_exclude);

    array_push($post_types, $extra_postypes_to_include);

    foreach ($post_types as $post_type) {
        register_rest_field( $post_type, 'ACF', [
            'get_callback'    => 'lf_expse_all_ACF_fields',
            'schema'          => null,
       ]
     );
    }

}

function lf_expse_all_ACF_fields( $object ) {
    $ID = $object['id'];
    return get_fields($ID);
}

add_action( 'rest_api_init', 'lf_crt_ACF_meta_in_appdev_REST' );

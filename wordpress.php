<?php
/**
 * Support for pre-initialising in mercator
 *
 * @package Mercator
 */

namespace Mercator;

function mercator_add_action( $tag, $function_to_add, $priority = 10, $accepted_args = 1 )
{
    mercator_add_filter( $tag, $function_to_add, $priority, $accepted_args );

    return true;
}

function mercator_add_filter( $tag, $function_to_add, $priority = 10, $accepted_args = 1 )
{
    if ( function_exists( 'add_filter' ) ) {
        add_filter( $tag, $function_to_add, $priority, $accepted_args );
    } else {
        $uid = ( is_string( $function_to_add ) ? $function_to_add : spl_object_hash( $function_to_add ) );

        $GLOBALS['wp_filter'][$tag][$priority]['mercator_' . $uid] = array(
            'function' => $function_to_add,
            'accepted_args' => $accepted_args,
        );
    }

    return true;
}

function mercator_did_action($tag)
{
    if (function_exists('did_action')) {
        return did_action($tag);
    } else {
        // We have no actions executable at this point, so no ;).
        return false;
    }
}
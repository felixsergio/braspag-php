<?php

if(!function_exists('fx_array_filter_recursive')){

    /**
     * Recursively filter an array
     *
     * @param array $array
     * @param callable $callback
     *
     * @return array
     */
    function fx_array_filter_recursive(array $array, callable $callback = null)
    {
        $array = is_callable( $callback ) ? array_filter( $array, $callback ) : array_filter( $array );
        foreach ( $array as &$value ) {
            if ( is_array( $value ) ) {
                $value = call_user_func( __FUNCTION__, $value, $callback );
            }
        }

        return $array;
    }
}

if(!function_exists('fx_cast_to_array_recursive')) {
    /**
     * Given mixed input, will recursively cast to an array if the input is an array or object.
     *
     * @param mixed $input Any input to possibly cast to array.
     * @return mixed
     */
    function fx_cast_to_array_recursive($input)
    {
        if (is_scalar($input)) {
            return $input;
        }

        return array_map(__FUNCTION__, (array)$input);
    }
}

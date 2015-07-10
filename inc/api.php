<?php

/**
 * Initializes the factory and stores the global instance
 * @return ShortcodeAliasFactory
 */
function ShortcodeAliasFactory()
{
    static $instance;
    if ( ! $instance ) {
        $instance = new ShortcodeAliasFactory();
    }

    return $instance;
}


/**
 * Register a NEW shortcode as an alias of another shortcode
 *
 * Optionally define default values for attributes &/or prepend/append them
 * to the attributes passed by the shortcode!
 *
 * Note: function arguments differ from add_shortcode! (with the exception of the first)
 *
 * @param  string $tag name of shortcode to add
 * @param  string $alias_of tag of shortcode to "connect" to
 * @param  mixed $defaults array of default attributes => values
 *
 * prepend / append
 * these are always applied as they are additive
 * The `+` denotes where the default value will be relative to the
 * shortcode-passed value.
 * E.g.:
 * `+content` (prepend)
 * `content+` (append)
 *
 * prepend a value:
 * +class => 'someclass ' with a shortcode that passes class="myclass"
 * will produce an html class attribute class="someclass myclass"
 *
 * append a value:
 * class+ => ' someclass' with a shortcode that passes class="myclass"
 * will produce an html class attribute class="myclass someclass"
 *
 * Defaults (no prepend/append):
 * defined values that are added if there is no existing value for the attribute
 * passed shortcode values will override defined defaults completely
 *
 * @return ShortcodeAlias
 */
function add_shortcode_alias( $tag, $alias_of, $defaults = false )
{
    return ShortcodeAliasFactory()->alias( $tag, $alias_of, $defaults );
}

/**
 * Remove all aliases for the given tag and restore the original callback if replaced with an alias
 * @param $tag
 * @return bool
 */
function remove_shortcode_alias( $tag )
{
    return ShortcodeAliasFactory()->revert( $tag, true );
}

/**
 * Revert the last alias on the given tag
 *
 * @param $tag
 *
 * @return bool
 */
function revert_shortcode_alias( $tag )
{
    return ShortcodeAliasFactory()->revert( $tag );
}


/**
 * Revert and remove all shortcode aliases
 */
function remove_all_shortcode_aliases()
{
    ShortcodeAliasFactory()->revert_all();
}

/**
 * Test whether or not a given shortcode tag is an alias
 *
 * @param $tag
 *
 * @return bool
 */
function is_shortcode_alias( $tag )
{
    global $shortcode_tags;
    return ! empty( $shortcode_tags[ $tag ][ 0 ] )
           && $shortcode_tags[ $tag ][ 0 ] instanceof ShortcodeAlias;
}

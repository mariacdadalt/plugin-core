<?php

namespace WPillar\Core\Abstractions;

use WPillar\Core\Services\Settings_Page\Settings_Page_Subscriber;
use WP_REST_Posts_Controller;

/**
 * Class Abstract_CPT. It helps setting a CPT.
 *
 * @package Rope\Core\Abstractions
 */
abstract class Abstract_CPT {

    /**
     * What is the name of this post type? If you don't override any of the labels,
     * this function will be used as base for creating the labels.
     * @return string
     */
    protected abstract function singular_name() : string;

    /**
     * This is the key of the post type and will be used as an identifier of it through the platform.
     * Must not exceed 20 characters and may only contain lowercase alphanumeric characters, dashes, and underscores.
     * @return string
     */
    public abstract function key() : string;

    /**
     * Function called by the Plugin to register all post_types it founds.
     * It is not recommended to override this function, as you will have to
     * recreate all the array for the post. Try overriding the other protected functions.
     * @see https://developer.wordpress.org/reference/functions/register_post_type/
     */
    public function register() {
        return register_post_type(
            $this->key(),
            [
                'labels'                => [
                    'name'                     => $this->label_general(),
                    'singular_name'            => $this->singular_name(),
                    'add_new'                  => $this->label_add_new(),
                    'add_new_item'             => $this->label_add_new_item(),
                    'edit_item'                => $this->label_edit_item(),
                    'new_item'                 => $this->label_new_item(),
                    'view_item'                => $this->label_view_item(),
                    'view_items'               => $this->label_view_items(),
                    'search_items'             => $this->label_search_items(),
                    'not_found'                => $this->label_not_found(),
                    'not_found_in_trash'       => $this->label_not_found_in_trash(),
                    'parent_item_colon'        => $this->label_parent_item_colon(),
                    'all_items'                => $this->label_all_items(),
                    'archives'                 => $this->label_archives(),
                    'attributes'               => $this->label_attributes(),
                    'insert_into_item'         => $this->label_insert_into_item(),
                    'uploaded_to_this_item'    => $this->label_uploaded_to_this_item(),
                    'featured_image'           => $this->label_featured_image(),
                    'set_featured_image'       => $this->label_set_featured_image(),
                    'menu_name'                => $this->label_menu_name(),
                    'filter_items_list'        => $this->label_filter_items_list(),
                    'items_list_navigation'    => $this->label_items_list_navigation(),
                    'items_list'               => $this->label_items_list(),
                    'item_published'           => $this->label_item_published(),
                    'item_published_privately' => $this->label_item_published_privately(),
                    'item_reverted_to_draft'   => $this->label_item_reverted_to_draft(),
                    'item_scheduled'           => $this->label_item_scheduled(),
                    'item_updated'             => $this->label_item_updated(),
                ],
                'description'           => $this->description(),
                'public'                => $this->public(),
                'hierarchical'          => $this->hierarchical(),
                'exclude_from_search'   => $this->exclude_from_search(),
                'publicly_queryable'    => $this->publicly_queryable(),
                'show_ui'               => $this->show_ui(),
                'show_in_menu'          => $this->show_in_menu(),
                'show_in_nav_menus'     => $this->show_in_nav_menus(),
                'show_in_admin_bar'     => $this->show_in_admin_bar(),
                'show_in_rest'          => $this->show_in_rest(),
                'rest_base'             => $this->rest_base(),
                'rest_controller_class' => $this->rest_controller_class(),
                'menu_position'         => $this->menu_position(),
                'menu_icon'             => $this->menu_icon(),
                'capability_type'       => $this->capability_type(),
                'map_meta_cap'          => $this->map_meta_cap(),
                'supports'              => $this->supports(),
                'taxonomies'            => $this->taxonomies(),
                'has_archive'           => $this->has_archive(),
                'rewrite'               => $this->rewrite(),
                'query_var'             => $this->query_var(),
                'can_export'            => $this->can_export(),
                'delete_with_user'      => $this->delete_with_user(),
                'template'              => $this->template_lock()
            ]
        );
    }

    /**
     * Defines the plural name of the post type.
     * Default to 'singular_name + s'.
     * @return string
     */
    protected function plural_name() : string {
        return __( $this->singular_name() . 's', ROPE_LANG );
    }

    /**
     * General name for the post type, usually plural.
     * Default is plural_name().
     * @return string
     */
    protected function label_general() : string {
        return $this->plural_name();
    }

    /**
     * Label for the add new button.
     * Default is 'Add new' for both hierarchical and non-hierarchical types.
     * @return string
     */
    protected function label_add_new() : string {
        return __( 'Add new', ROPE_LANG );
    }

    /**
     * Label for adding a new singular item.
     * Default is 'Add new + singular_name'.
     * @return string
     */
    protected function label_add_new_item() : string {
        return __( 'Add new ', ROPE_LANG ) . $this->singular_name();
    }

    /**
     * Label for editing a singular item.
     * Default is 'Edit + singular_name'.
     * @return string
     */
    protected function label_edit_item() : string {
        return __( 'Edit ', ROPE_LANG ) . $this->singular_name();
    }

    /**
     * Label for the new item page title.
     * Default is 'New + singular_name'
     * @return string
     */
    protected function label_new_item() : string {
        return __( 'New ', ROPE_LANG ) . $this->singular_name();
    }

    /**
     * Label for viewing a singular item.
     * Default is 'View + singular_name'
     * @return string
     */
    protected function label_view_item() : string {
        return __( 'View ', ROPE_LANG ) . $this->singular_name();
    }

    /**
     * Label for viewing post type archives.
     * Default is 'View + plural_name'.
     * @return string
     */
    protected function label_view_items() : string {
        return __( 'View ', ROPE_LANG ) . $this->plural_name();
    }

    /**
     * Label for searching plural items.
     * Default to 'Search + plural_name'.
     * @return string
     */
    protected function label_search_items() : string {
        return __( 'Search ', ROPE_LANG ) . $this->plural_name();
    }

    /**
     * Label used when no items are found.
     * Default is 'No singular_name found'.
     * @return string
     */
    protected function label_not_found() : string {
        return __( 'No ', ROPE_LANG ) . $this->singular_name() . __( ' found.', ROPE_LANG );
    }

    /**
     * Label used when no items are found in Trash.
     * Default is 'No singular_name found in Trash'.
     * @return string
     */
    protected function label_not_found_in_trash() : string {
        return __( 'No ', ROPE_LANG ) . $this->singular_name() . __( ' found in Trash.', ROPE_LANG );
    }

    /**
     * Label used to prefix parents of hierarchical items. Not used on non-hierarchical post types.
     * Default is 'Parent singular_name:'
     * @return string
     */
    protected function label_parent_item_colon() : string {
        return __( 'Parent ', ROPE_LANG ) . $this->singular_name() . ':';
    }

    /**
     * Label to signify all items in a submenu link.
     * Default is 'All plural_name'
     * @return string
     */
    protected function label_all_items() : string {
        return __( 'All ', ROPE_LANG ) . $this->plural_name();
    }

    /**
     * Label for archives in nav menus.
     * Default is 'singular_name Archives"
     * @return string
     */
    protected function label_archives() : string {
        return $this->singular_name() . __( 'Archives', ROPE_LANG );
    }

    /**
     * Label for the attributes meta box.
     * Default is 'singular_name Attributes'
     * @return string
     */
    protected function label_attributes() : string {
        return $this->singular_name() . __( 'Attributes', ROPE_LANG );
    }

    protected function label_insert_into_item() : string {
        return __( 'Inserir no(a) ', ROPE_LANG ) . $this->singular_name();
    }

    protected function label_uploaded_to_this_item() : string {
        return __( 'Anexado neste(a) ', ROPE_LANG ) . $this->singular_name();
    }

    protected function label_featured_image() : string {
        return __( 'Imagem Destacada', ROPE_LANG );
    }

    protected function label_set_featured_image() : string {
        return __( 'Selecionar Imagem Destacada', ROPE_LANG );
    }

    protected function label_remove_featured_image() : string {
        return __( 'Remover Imagem Destacada', ROPE_LANG );
    }

    protected function label_use_featured_image() : string {
        return __( 'Usar Imagem Destacada', ROPE_LANG );
    }

    protected function label_menu_name() : string {
        return $this->label_general();
    }

    protected function label_filter_items_list() : string {
        return __( 'Filtrar lista de ', ROPE_LANG ) . $this->singular_name();
    }

    protected function label_items_list_navigation() : string {
        return __( 'Navegação de ', ROPE_LANG ) . $this->singular_name();
    }

    protected function label_items_list() : string {
        return __( 'Lista de ', ROPE_LANG ) . $this->singular_name();
    }

    protected function label_item_published() : string {
        return $this->singular_name() . __( ' publicado(a).', ROPE_LANG );
    }

    protected function label_item_published_privately() : string {
        return $this->singular_name() . __( ' publicado(a) de forma privada.', ROPE_LANG );
    }

    protected function label_item_reverted_to_draft() : string {
        return $this->singular_name() . __( ' revertido(a) à rascunho.', ROPE_LANG );
    }

    protected function label_item_scheduled() : string {
        return $this->singular_name() . __( ' agendado(a).', ROPE_LANG );
    }

    protected function label_item_updated() : string {
        return $this->singular_name() . __( ' atualizado(a).', ROPE_LANG );
    }

    protected function public() : bool {
        return true;
    }

    protected function description() : string {
        return __( 'Esse é o CPT: ', ROPE_LANG ) . $this->singular_name();
    }

    protected function hierarchical() : bool {
        return false;
    }

    protected function exclude_from_search() : bool {
        return ! $this->public();
    }

    protected function publicly_queryable() : bool {
        return ! $this->public();
    }

    protected function show_ui() : bool {
        return $this->public();
    }

    /**
     * Where to show the post type in the admin menu.
     * To work, $show_ui must be true. If true, the post type is shown in its own top level menu.
     * If false, no menu is shown.
     * If a string, it is shown as a submenu of the url set here.
     * Default: submenu of the Modern Rope Menu.
     * @return bool|string
     */
    protected function show_in_menu() {
        return Settings_Page_Subscriber::PARENT_SLUG;
    }

    protected function show_in_nav_menus() : bool {
        return $this->public();
    }

    protected function show_in_admin_bar() : bool {
        return false;
    }

    protected function show_in_rest() : bool {
        return false;
    }

    protected function rest_base() : string {
        return $this->key();
    }

    protected function rest_controller_class() : string {
        return WP_REST_Posts_Controller::class;
    }

    protected function menu_position() : int {
        return 99;
    }

    /**
     * The name of the icon you want to appear.
     *
     * @link https://developer.wordpress.org/resource/dashicons/
     * @return string
     */
    protected function menu_icon() : string {
        return 'dashicons-info';
    }

    /**
     * Set this function to $this->key() if you want this cpt to have
     * its own set of capabilities.
     *
     * @return string
     */
    protected function capability_type() : string {
        return 'post';
    }

    protected function capabilities() : array {
        return [];
    }

    /**
     * Does this CPT needs the default meta caps or can
     * he inherit from posts?
     *
     * @return bool
     */
    protected function map_meta_cap() : bool {
        return false;
    }

    /**
     * What this CPT supports out of the box?
     * Possible values: title, editor, comments, revisions, trackbacks,
     * author, excerpt, page-attributes, thumbnail, custom-fields, post-formats
     * Default to 'title'.
     * @return array
     */
    protected function supports() : array {
        return [
            'title',
        ];
    }

    protected function taxonomies() : array {
        return [];
    }

    protected function has_archive() : bool {
        return false;
    }

    /**
     * Triggers the handling of rewrites for this post type.
     * To specify rewrite rules, an array can be passed with any of these keys:
     * array( 'slug', 'with_front', 'feeds', 'pages', 'ep_mask').
     * @see https://developer.wordpress.org/reference/functions/register_post_type/
     * @return array
     */
    protected function rewrite() : array {
        return [
            'slug' => $this->key(),
        ];
    }

    /**
     * @return string
     */
    protected function query_var() : string {
        return $this->key();
    }

    protected function can_export() : bool {
        return true;
    }

    protected function delete_with_user() : bool {
        return true;
    }

    /**
     * Array of blocks to use as the default initial state for an editor session.
     * Each item should be an array containing block name and optional attributes.
     * @return array
     */
    protected function template() : array {
        return [];
    }

    /**
     * Whether the block template should be locked if template() is set.
     * Option 'all' doesn't let user move, insert or delete blocks.
     * Option 'insert' doesn't let user insert or delete blocks.
     * Defaults to false.
     * @return string|false
     */
    protected function template_lock() {
        return false;
    }


}

<?php

// phpcs:disable WordPress.WP.I18n.NonSingularStringLiteralText
// phpcs:disable WordPress.WP.I18n.NonSingularStringLiteralDomain

declare(strict_types=1);

namespace Plugin\Core\Abstractions;

use Plugin\Core\Services\Settings_Page\Settings_Page_Subscriber;
use WP_Error;
use WP_Post_Type;
use WP_REST_Posts_Controller;

/**
 * Class AbstractCPT. It helps setting a CPT.
 *
 * @package Rope\Core\Abstractions
 */
abstract class AbstractCPT
{
    public const LOCAL_LANG_CODE = PLUGIN_CORE_LANG;

    /**
     * What is the name of this post type? If you don't override any of the labels,
     * this function will be used as base for creating the labels.
     * @return string
     */
    abstract protected function singularName(): string;

    /**
     * This is the key of the post type and will be used as an identifier of it
     * through the platform. Must not exceed 20 characters and may only contain
     * lowercase alphanumeric characters, dashes, and underscores.
     * @return string
     */
    abstract public function key(): string;

    /**
     * Function called by the Plugin to register all post_types it founds.
     * It is not recommended to override this function, as you will have to
     * recreate all the array for the post. Try overriding the other protected functions.
     * @see https://developer.wordpress.org/reference/functions/register_post_type/
     */
    public function register(): WP_Post_Type|WP_Error
    {

        return register_post_type(
            $this->key(),
            [
                'labels' => $this->labels(),
                'description' => $this->description(),
                'public' => $this->public(),
                'hierarchical' => $this->hierarchical(),
                'exclude_from_search' => $this->excludeFromSearch(),
                'publicly_queryable' => $this->publiclyQueryable(),
                'show_ui' => $this->showUi(),
                'show_in_menu' => $this->showInMenu(),
                'show_in_nav_menus' => $this->showInNavMenus(),
                'show_in_admin_bar' => $this->showInAdminBar(),
                'show_in_rest' => $this->showInRest(),
                'rest_base' => $this->restBase(),
                'rest_controller_class' => $this->restControllerClass(),
                'menu_position' => $this->menuPosition(),
                'menu_icon' => $this->menuIcon(),
                'capability_type' => $this->capabilityType(),
                'map_meta_cap' => $this->mapMetaCap(),
                'supports' => $this->supports(),
                'taxonomies' => $this->taxonomies(),
                'has_archive' => $this->hasArchive(),
                'rewrite' => $this->rewrite(),
                'query_var' => $this->queryVar(),
                'can_export' => $this->canExport(),
                'delete_with_user' => $this->deleteWithUser(),
                'template' => $this->templateLock(),
            ]
        );
    }

    protected function labels(): array
    {

        return [
            'name' => $this->labelGeneral(),
            'singular_name' => $this->singularName(),
            'add_new' => $this->labelAddNew(),
            'add_new_item' => $this->labelAddNewItem(),
            'edit_item' => $this->labelEditItem(),
            'new_item' => $this->labelNewItem(),
            'view_item' => $this->labelViewItem(),
            'view_items' => $this->labelViewItems(),
            'search_items' => $this->labelSearchItems(),
            'not_found' => $this->labelNotFound(),
            'not_found_in_trash' => $this->labelNotFoundInTrash(),
            'parent_item_colon' => $this->labelParentItemColon(),
            'all_items' => $this->labelAllItems(),
            'archives' => $this->labelArchives(),
            'attributes' => $this->labelAttributes(),
            'insert_into_item' => $this->labelInsertIntoItem(),
            'uploaded_to_this_item' => $this->labelUploadedToThisItem(),
            'featured_image' => $this->labelFeaturedImage(),
            'set_featured_image' => $this->labelSetFeaturedImage(),
            'menu_name' => $this->labelMenuMame(),
            'filter_items_list' => $this->labelFilterItemsList(),
            'items_list_navigation' => $this->labelItemsListNavigation(),
            'items_list' => $this->labelItemsList(),
            'item_published' => $this->labelItemPublished(),
            'item_published_privately' => $this->labelItemPublishedPrivately(),
            'item_reverted_to_draft' => $this->labelItemRevertedToDraft(),
            'item_scheduled' => $this->labelItemScheduled(),
            'item_updated' => $this->labelItemUpdated(),
        ];
    }

    /**
     * Defines the plural name of the post type.
     * Default to 'singularName + s'.
     * @return string
     */
    protected function pluralName(): string
    {

        return __($this->singularName() . 's', self::LOCAL_LANG_CODE);
    }

    /**
     * General name for the post type, usually plural.
     * Default is pluralName().
     * @return string
     */
    protected function labelGeneral(): string
    {

        return $this->pluralName();
    }

    /**
     * Label for the add new button.
     * Default is 'Add new' for both hierarchical and non-hierarchical types.
     * @return string
     */
    protected function labelAddNew(): string
    {

        return __('Add new', self::LOCAL_LANG_CODE);
    }

    /**
     * Label for adding a new singular item.
     * Default is 'Add new + singularName'.
     * @return string
     */
    protected function labelAddNewItem(): string
    {

        return __('Add new ', self::LOCAL_LANG_CODE) . $this->singularName();
    }

    /**
     * Label for editing a singular item.
     * Default is 'Edit + singularName'.
     * @return string
     */
    protected function labelEditItem(): string
    {

        return __('Edit ', self::LOCAL_LANG_CODE) . $this->singularName();
    }

    /**
     * Label for the new item page title.
     * Default is 'New + singularName'
     * @return string
     */
    protected function labelNewItem(): string
    {

        return __('New ', self::LOCAL_LANG_CODE) . $this->singularName();
    }

    /**
     * Label for viewing a singular item.
     * Default is 'View + singularName'
     * @return string
     */
    protected function labelViewItem(): string
    {

        return __('View ', self::LOCAL_LANG_CODE) . $this->singularName();
    }

    /**
     * Label for viewing post type archives.
     * Default is 'View + pluralName'.
     * @return string
     */
    protected function labelViewItems(): string
    {

        return __('View ', self::LOCAL_LANG_CODE) . $this->pluralName();
    }

    /**
     * Label for searching plural items.
     * Default to 'Search + pluralName'.
     * @return string
     */
    protected function labelSearchItems(): string
    {

        return __('Search ', self::LOCAL_LANG_CODE) . $this->pluralName();
    }

    /**
     * Label used when no items are found.
     * Default is 'No singularName found'.
     * @return string
     */
    protected function labelNotFound(): string
    {

        return __('No ', self::LOCAL_LANG_CODE) .
            $this->singularName() .
            __(' found.', self::LOCAL_LANG_CODE);
    }

    /**
     * Label used when no items are found in Trash.
     * Default is 'No singularName found in Trash'.
     * @return string
     */
    protected function labelNotFoundInTrash(): string
    {

        return __('No ', self::LOCAL_LANG_CODE) . $this->singularName() . __(' found in Trash.', self::LOCAL_LANG_CODE);
    }

    /**
     * Label used to prefix parents of hierarchical items. Not used on non-hierarchical post types.
     * Default is 'Parent singularName:'
     * @return string
     */
    protected function labelParentItemColon(): string
    {

        return __('Parent ', self::LOCAL_LANG_CODE) . $this->singularName() . ':';
    }

    /**
     * Label to signify all items in a submenu link.
     * Default is 'All pluralName'
     * @return string
     */
    protected function labelAllItems(): string
    {

        return __('All ', self::LOCAL_LANG_CODE) . $this->pluralName();
    }

    /**
     * Label for archives in nav menus.
     * Default is 'singularName Archives"
     * @return string
     */
    protected function labelArchives(): string
    {

        return $this->singularName() . __('Archives', self::LOCAL_LANG_CODE);
    }

    /**
     * Label for the attributes meta box.
     * Default is 'singularName Attributes'
     * @return string
     */
    protected function labelAttributes(): string
    {

        return $this->singularName() . __('Attributes', self::LOCAL_LANG_CODE);
    }

    protected function labelInsertIntoItem(): string
    {

        return __('Inserir no(a) ', self::LOCAL_LANG_CODE) . $this->singularName();
    }

    protected function labelUploadedToThisItem(): string
    {

        return __('Anexado neste(a) ', self::LOCAL_LANG_CODE) . $this->singularName();
    }

    protected function labelFeaturedImage(): string
    {

        return __('Imagem Destacada', self::LOCAL_LANG_CODE);
    }

    protected function labelSetFeaturedImage(): string
    {

        return __('Selecionar Imagem Destacada', self::LOCAL_LANG_CODE);
    }

    protected function labelRemoveFeaturedImage(): string
    {

        return __('Remover Imagem Destacada', self::LOCAL_LANG_CODE);
    }

    protected function labelUseFeaturedImage(): string
    {

        return __('Usar Imagem Destacada', self::LOCAL_LANG_CODE);
    }

    protected function labelMenuMame(): string
    {

        return $this->labelGeneral();
    }

    protected function labelFilterItemsList(): string
    {

        return __('Filtrar lista de ', self::LOCAL_LANG_CODE) . $this->singularName();
    }

    protected function labelItemsListNavigation(): string
    {

        return __('Navegação de ', self::LOCAL_LANG_CODE) . $this->singularName();
    }

    protected function labelItemsList(): string
    {

        return __('Lista de ', self::LOCAL_LANG_CODE) . $this->singularName();
    }

    protected function labelItemPublished(): string
    {

        return $this->singularName() . __(' publicado(a).', self::LOCAL_LANG_CODE);
    }

    protected function labelItemPublishedPrivately(): string
    {

        return $this->singularName() . __(' publicado(a) de forma privada.', self::LOCAL_LANG_CODE);
    }

    protected function labelItemRevertedToDraft(): string
    {

        return $this->singularName() . __(' revertido(a) à rascunho.', self::LOCAL_LANG_CODE);
    }

    protected function labelItemScheduled(): string
    {

        return $this->singularName() . __(' agendado(a).', self::LOCAL_LANG_CODE);
    }

    protected function labelItemUpdated(): string
    {

        return $this->singularName() . __(' atualizado(a).', self::LOCAL_LANG_CODE);
    }

    protected function public(): bool
    {

        return true;
    }

    protected function description(): string
    {

        return __('Esse é o CPT: ', self::LOCAL_LANG_CODE) . $this->singularName();
    }

    protected function hierarchical(): bool
    {

        return false;
    }

    protected function excludeFromSearch(): bool
    {

        return ! $this->public();
    }

    protected function publiclyQueryable(): bool
    {

        return ! $this->public();
    }

    protected function showUi(): bool
    {

        return $this->public();
    }

    /**
     * Where to show the post type in the admin menu.
     * To work, $show_ui must be true. If true, the post type is shown in its own top level menu.
     * If false, no menu is shown.
     * If a string, it is shown as a submenu of the url set here.
     * @return bool|string
     */
    protected function showInMenu(): string|bool
    {
        return Settings_Page_Subscriber::PARENT_SLUG;
    }

    protected function showInNavMenus(): bool
    {

        return $this->public();
    }

    protected function showInAdminBar(): bool
    {

        return false;
    }

    protected function showInRest(): bool
    {

        return false;
    }

    protected function restBase(): string
    {

        return $this->key();
    }

    protected function restControllerClass(): string
    {

        return WP_REST_Posts_Controller::class;
    }

    protected function menuPosition(): int
    {

        return 99;
    }

    /**
     * The name of the icon you want to appear.
     *
     * @link https://developer.wordpress.org/resource/dashicons/
     * @return string
     */
    protected function menuIcon(): string
    {

        return 'dashicons-info';
    }

    /**
     * Set this function to $this->key() if you want this cpt to have
     * its own set of capabilities.
     *
     * @return string
     */
    protected function capabilityType(): string
    {

        return 'post';
    }

    protected function capabilities(): array
    {

        return [];
    }

    /**
     * Does this CPT needs the default meta caps or can
     * he inherit from posts?
     *
     * @return bool
     */
    protected function mapMetaCap(): bool
    {

        return false;
    }

    /**
     * What this CPT supports out of the box?
     * Possible values: title, editor, comments, revisions, trackbacks,
     * author, excerpt, page-attributes, thumbnail, custom-fields, post-formats
     * Default to 'title'.
     * @return array
     */
    protected function supports(): array
    {

        return [
            'title',
        ];
    }

    protected function taxonomies(): array
    {

        return [];
    }

    protected function hasArchive(): bool
    {

        return false;
    }

    /**
     * Triggers the handling of rewrites for this post type.
     * To specify rewrite rules, an array can be passed with any of these keys:
     * array( 'slug', 'with_front', 'feeds', 'pages', 'ep_mask').
     * @see https://developer.wordpress.org/reference/functions/register_post_type/
     * @return array
     */
    protected function rewrite(): array
    {

        return [
            'slug' => $this->key(),
        ];
    }

    /**
     * @return string
     */
    protected function queryVar(): string
    {

        return $this->key();
    }

    protected function canExport(): bool
    {

        return true;
    }

    protected function deleteWithUser(): bool
    {

        return true;
    }

    /**
     * Array of blocks to use as the default initial state for an editor session.
     * Each item should be an array containing block name and optional attributes.
     * @return array
     */
    protected function template(): array
    {

        return [];
    }

    /**
     * Whether the block template should be locked if template() is set.
     * Option 'all' doesn't let user move, insert or delete blocks.
     * Option 'insert' doesn't let user insert or delete blocks.
     * Defaults to false.
     * @return string|false
     */
    protected function templateLock(): bool|string
    {
        return false;
    }
}

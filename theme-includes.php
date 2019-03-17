<?php

define('QODE_ROOT', get_template_directory_uri());
define('QODE_ROOT_DIR', get_template_directory());
define('QODE_VAR_PREFIX', 'qode_');
define('QODE_FRAMEWORK_ROOT', get_template_directory_uri().'/framework');
define('QODE_FRAMEWORK_ROOT_DIR', get_template_directory().'/framework');
define('QODE_SHORTCODES_ROOT_DIR', get_template_directory().'/includes/shortcodes/shortcode-elements');
define('QODE_FRAMEWORK_MODULES_ROOT', get_template_directory_uri().'/framework/modules');
define('QODE_FRAMEWORK_MODULES_ROOT_DIR', get_template_directory().'/framework/modules');

include_once('framework/qode-framework.php');
include_once('includes/shortcodes/shortcodes.php');
include_once('includes/import/qode-import.php');
//include_once('export/qode-export.php');
include_once('includes/custom-fields-post-formats.php');
include_once('includes/qode-breadcrumbs.php');
include_once('includes/nav_menu/qode-menu.php');
include_once('includes/sidebar/qode-custom-sidebar.php');
include_once('includes/qode-custom-post-types.php');
include_once('includes/qode-like.php' );
include_once('includes/qode-custom-taxonomy-field.php');
include_once('includes/header/qode-header-functions.php');
include_once('includes/title/qode-title-functions.php');
include_once('includes/qode-portfolio-functions.php');
include_once('includes/qode-product-list.php');
include_once('includes/qode-loading-spinners.php');
/* Include comment functionality */
include_once('includes/comment/comment.php');
/* Include sidebar functionality */
include_once('includes/sidebar/sidebar.php');
/* Include pagination functionality */
include_once('includes/pagination/pagination.php');
/* Include qode carousel select box for visual composer */
include_once('includes/qode_carousel/qode-carousel.php');
/* Include font awesome icons list */
include_once('includes/font_awesome/font-awesome.php');
include_once('includes/elegant_icons/elegant-icons.php');
include_once('includes/linear_icons/linear-icons.php');
/** Include the TGM_Plugin_Activation class. */
require_once dirname( __FILE__ ) . '/includes/plugins/class-tgm-plugin-activation.php';
/* Include activation for plugins */
include_once('includes/plugins/plugins-activation.php');

include_once('widgets/call_to_action_widget.php');
<?php
/**
 * C42 WooCommerce Product Meta Framework
 *
 * @package           C42WooCommerceProductMetaFramework
 * @author            Cram42
 * @copyright         2024 Grant Le Roux
 * @license           GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       C42 WooCommerce Product Meta Framework
 * Plugin URI:        https://github.com/Cram42/woocommerce-product-meta-framework
 * Version:           0.0.1
 * Requires at least: 6.4.2
 * Requires PHP:      8.2
 * Author:            Cram42
 * Author URI:        https://github.com/Cram42
 * License:           GPL v3 or later
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       cram42-wpf
 * Update URI:        https://github.com/Cram42/woocommerce-product-meta-framework
 */

namespace WCProductMetaFramework;

use WPPluginFramework as WPF;

function activate()
{
    if (!class_exists('\WPPluginFramework\ClassFinder')) {
        throw new \Exception("Must load WordPress Plugin Framework first.");
    }
    WPF\ClassFinder::addNamespacePath(__NAMESPACE__, dirname(__FILE__) . '/src', true);
    WPF\ClassFinder::addNamespacePath(__NAMESPACE__, dirname(__FILE__) . '/src/StaticFields', true);
    WPF\ClassFinder::addNamespacePath(__NAMESPACE__, dirname(__FILE__) . '/src/DBFields', true);
}
register_activation_hook(__FILE__, __NAMESPACE__ . '\activate');

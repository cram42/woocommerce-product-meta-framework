<?php

if (!class_exists('WPPluginFramework\ClassFinder')) {
    throw new \Exception("Must load WordPress Plugin Framework first.");
}

\WPPluginFramework\ClassFinder::register();
$wcppf_class_finder_handle = \WPPluginFramework\ClassFinder::getHandle();
$wcppf_class_finder_handle->addNamespacePath('WCProductMetaFramework', dirname(__FILE__) . '/src', true);
$wcppf_class_finder_handle->addNamespacePath('WCProductMetaFramework', dirname(__FILE__) . '/src/StaticFields', true);
$wcppf_class_finder_handle->addNamespacePath('WCProductMetaFramework', dirname(__FILE__) . '/src/DBFields', true);

<?php

if (!class_exists('WPPluginFramework\ClassFinder')) {
    throw new \Exception("Must load WordPress Plugin Framework first.");
}

\WPPluginFramework\ClassFinder::addNamespacePath('WCProductMetaFramework', dirname(__FILE__) . '/src', true);
\WPPluginFramework\ClassFinder::addNamespacePath('WCProductMetaFramework', dirname(__FILE__) . '/src/StaticFields', true);
\WPPluginFramework\ClassFinder::addNamespacePath('WCProductMetaFramework', dirname(__FILE__) . '/src/DBFields', true);

<?php

namespace WCProductMetaFramework;

use WPPluginFramework as WPF;

abstract class DatabaseList extends WPF\Singleton implements
    WPF\IOnPluginLoad,
    WPF\IOnPluginEnable,
    WPF\IOnPluginDisable,
    WPF\IOnPluginUninstall
{
    protected const VALID_ORDER_BY = array('id', 'value', 'label');

    protected string $id;
    protected string $table_name;
    protected $default_items = array();

    protected $items;

    protected bool $wipe_on_disable = false;
    protected bool $wipe_on_uninstall = true;

    protected function createTable()
    {
        global $wpdb;
        error_log("DatabaseList({$this->getId()})::createTable()");

        $query = sprintf("
            CREATE TABLE %s (
                id int NOT NULL AUTO_INCREMENT,
                value varchar(100) NOT NULL,
                label varchar(100) NOT NULL,
                PRIMARY KEY (id)
            ) %s;",
            $this->getTableName(),
            $wpdb->get_charset_collate()
        );

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($query);
    }

    protected function deleteTable()
    {
        global $wpdb;
        error_log("DatabaseList({$this->getId()})::deleteTable()");

        $query = sprintf("DROP TABLE IF EXISTS %s;", $this->getTableName());
        $wpdb->query($query);
    }

    protected function populateTable()
    {
        global $wpdb;
        error_log("DatabaseList({$this->getId()})::populateTable()");
        
        foreach ($this->default_items as $item) {
            $wpdb->replace($this->getTableName(), $item);
        }
    }

    #region Public Methods

    public function getItems($order_by = null, $order_desc = false)
    {
        error_log("DatabaseList({$this->getId()})::getItems()");
        
        $order_by = in_array($order_by, static::VALID_ORDER_BY) 
            ? $order_by 
            : static::VALID_ORDER_BY[0];

        if ($this->items == null) {
            global $wpdb;
            $query = sprintf("SELECT value, label FROM %s ORDER BY %s %s;", $this->getTableName(), $order_by, ($order_desc) ? 'DESC' : '');
            $results = $wpdb->get_results($query);
            
            $this->items = array();
            foreach ($results as $result) {
                $this->items[$result->value] = $result->label;
            }
        }
        return $this->items;
    }

    public function getId() : string
    {
        if (empty($this->id)) {
            $class_name = get_class($this);
            $class_name = preg_replace('/Field$/', '', $class_name);
            $class_name = strtolower(str_replace('\\', '_', $class_name));
            $this->id = $class_name;
        }
        return $this->id;
    }

    public function getTableName() : string
    {
        if (empty($this->table_name)) {
            global $wpdb;
            $table_name = $wpdb->prefix . $this->getId();
            $this->table_name = $table_name;
        }
        return $this->table_name;
    }

    public function OnPluginLoad() : void
    {
        error_log("DatabaseList({$this->getId()})::OnPluginLoad()");
    }

    public function OnPluginEnable() : void
    {
        error_log("DatabaseList({$this->getId()})::OnPluginEnable()");
        $this->createTable();
        $this->populateTable();
    }

    public function OnPluginDisable() : void
    {
        error_log("DatabaseList({$this->getId()})::OnPluginDisable()");
        if ($this->wipe_on_disable) {
            $this->deleteTable();
        }
    }

    public function OnPluginUninstall() : void
    {
        error_log("DatabaseList({$this->getId()})::OnPluginUninstall()");
        if ($this->wipe_on_uninstall) {
            $this->deleteTable();
        }
    }
    #endregion
}
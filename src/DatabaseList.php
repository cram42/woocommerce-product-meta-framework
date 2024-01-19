<?php

namespace WCProductMetaFramework;

use WPPluginFramework as WPF;

abstract class DatabaseList extends WPF\DBTable
{
    protected $items;

    protected const VALID_ORDER_BY = array('id', 'value', 'label');
    
    protected array $column_definitions = array(
        'value varchar(100) NOT NULL',
        'label varchar(100) NOT NULL',
    );

    protected array $default_records = array();

    public function getId(): string
    {
        if (empty($this->id)) {
            $class_name = get_class($this);
            $class_name = preg_replace('/List$/', '', $class_name);
            $class_name = strtolower(str_replace('\\', '_', $class_name));
            $this->id = $class_name;
        }
        return $this->id;
    }

    public function getItems(string $order_by = '', $order_desc = false)
    {
        error_log("DatabaseList({$this->getId()})::getItems()");
        
        $order_by = in_array($order_by, static::VALID_ORDER_BY) 
            ? $order_by 
            : static::VALID_ORDER_BY[0];

        if ($this->items == null) {
            $results = $this->readAll($order_by, $order_desc);
            $this->items = array();
            foreach ($results as $result) {
                $value = $result['value'];
                $label = $result['label'];
                $this->items[$value] = $label;
            }
        }
        return $this->items;
    }

}
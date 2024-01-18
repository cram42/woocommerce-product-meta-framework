<?php

namespace WCProductMetaFramework;

use WPPluginFramework as WPF;

abstract class BaseField extends WPF\Singleton implements
    WPF\IOnPluginLoad,
    WPF\IOnPluginEnable,
    WPF\IOnPluginDisable,
    WPF\IOnPluginUninstall
{
    protected string $id;
    protected string $label;
    protected string $desription = '';
    protected bool   $description_as_tip = true;

    protected string $class = 'short';
    protected mixed  $wrapper_class = null;
    protected mixed  $style = null;

    protected string $target = FieldTarget::DEFAULT;

    protected bool $wipe_on_disable = false;
    protected bool $wipe_on_uninstall = true;

    protected function getId(): string
    {
        if (empty($this->id)) {
            $class_name = get_class($this);
            $class_name = preg_replace('/Field$/', '', $class_name);
            $class_name = '_' . strtolower(str_replace('\\', '_', $class_name));
            $this->id = $class_name;
        }
        return $this->id;
    }

    protected function getLabel(): string
    {
        if (empty($this->label)) {
            $label = get_class($this);
            $label = preg_replace('/Field$/', '', $label);
            $pos = max(0, strrpos($label, '\\'));
            $label = substr($label, $pos + 1);
            $label = preg_replace('/([^A-Z])([A-Z])/', '\1 \2', $label);
            $this->label = $label;
        }
        return $this->label;
    }

    protected function getDescription(): string
    {
        if (empty($this->description)) {
            $description = sprintf(
                'Added by %s',
                get_class($this)
            );
            $this->description = $description;
        }
        return $this->description;
    }

    protected function drawMetaBox(): void
    {
        echo('<p class="form-field ' . esc_attr($this->getId()) . '_field">');
        echo('<label for="' . $this->getId() . '">' . $this->getLabel() . '</label>');

        if ($this->description_as_tip) {
            echo(wc_help_tip($this->getDescription()));
        }

        echo('<input type="text" disabled="disabled" class="short" placeholder="' . $this->getId() . '"></input>');

        if (!$this->description_as_tip) {
            echo('<span class="description">' . $this->getDescription() . '</span>');
        }

        echo('</p>');

    }

    protected function processSaveValue($value): mixed
    {
        return $value;
    }

    #region Public Methods

    protected function wipeField(): void
    {
        error_log(sprintf('BaseField(%s)::wipeField()', $this->getId()));
        delete_metadata('post', 0, $this->getId(), true);
    }

    public function OnPluginLoad(): void
    {
        // Hook display
        add_action($this->target, array($this, 'OnShowMetaBox'));

        // Hook save
        add_action('woocommerce_process_product_meta', array($this, 'OnProcessMeta'));
    }

    public function OnPluginEnable(): void
    {
        error_log("MetaFieldBase({$this->getId()})::OnPluginEnable()");
    }

    public function OnPluginDisable(): void
    {
        error_log("MetaFieldBase({$this->getId()})::OnPluginDisable()");
        if ($this->wipe_on_disable) {
            $this->wipeField();
        }
    }

    public function OnPluginUninstall(): void
    {
        error_log("MetaFieldBase({$this->getId()})::OnPluginUninstall()");
        if ($this->wipe_on_uninstall) {
            $this->wipeField();
        }
    }

    public function OnShowMetaBox(): void
    {
        error_log(sprintf('BaseField(%s)::OnShowMetaBox()', $this->getId()));
        $this->drawMetaBox();
    }

    public function OnProcessMeta($post_id): void
    {
        error_log(sprintf('BaseField(%s)::OnProcessMeta(%d)', $this->getId(), $post_id));
        if (isset($_POST[$this->getId()])) {
            $value = $_POST[$this->getId()];
        } else {
            $value = $this->processSaveValue(null);
        }
        update_post_meta($post_id, $this->getId(), $value);
    }

    #endregion
}

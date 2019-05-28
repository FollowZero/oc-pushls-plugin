<?php namespace Plus\Pushls;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'plus.pushls::lang.settings.menu_label',
                'description' => 'plus.pushls::lang.settings.menu_description',
                'category'    => 'plus.pushls::lang.plugin.name',
                'icon'        => 'icon-cog',
                'class'       => 'plus\Pushls\Models\Settings',
                'order'       => 500,
                'permissions' => ['']
            ],
        ];
    }
}

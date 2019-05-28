<?php
/**
 * Created by PhpStorm.
 * User: 38577
 * Date: 2019/5/27
 * Time: 16:41
 */
namespace Plus\Pushls\Models;
use Lang;
use Model;
class Settings extends Model
{
    /**
     * @var array Behaviors implemented by this model.
     */
    public $implement = [
        \System\Behaviors\SettingsModel::class
    ];
    public $settingsCode = 'pushls_settings';
    public $settingsFields = 'fields.yaml';
}
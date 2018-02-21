<?php
/**
 * PJAX plugin for Craft CMS 3.x
 *
 * Return only the container that PJAX expects, automagically
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\pjax;

use superbig\pjax\services\PJAXService;
use superbig\pjax\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\events\TemplateEvent;
use craft\web\View;

use yii\base\Event;

/**
 * Class PJAX
 *
 * @author    Superbig
 * @package   PJAX
 * @since     1.0.0
 *
 * @property  PJAXService $pjaxService
 */
class PJAX extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var PJAX
     */
    public static $plugin;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            View::class,
            View::EVENT_AFTER_RENDER_PAGE_TEMPLATE,
            function (TemplateEvent $event) {
                $event->output = $this->pjaxService->output($event->output);
            }
        );

        Craft::info(
            Craft::t(
                'pjax',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }
}

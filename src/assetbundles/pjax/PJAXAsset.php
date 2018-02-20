<?php
/**
 * PJAX plugin for Craft CMS 3.x
 *
 * Return only the container that PJAX expects, automagically
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\pjax\assetbundles\PJAX;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Superbig
 * @package   PJAX
 * @since     1.0.0
 */
class PJAXAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@superbig/pjax/assetbundles/pjax/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/PJAX.js',
        ];

        $this->css = [
            'css/PJAX.css',
        ];

        parent::init();
    }
}

<?php
/**
 * PJAX plugin for Craft CMS 3.x
 *
 * Return only the container that PJAX expects, automagically
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\pjax\models;

use superbig\pjax\PJAX;

use Craft;
use craft\base\Model;

/**
 * @author    Superbig
 * @package   PJAX
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var bool
     */
    public $enabled = true;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }
}

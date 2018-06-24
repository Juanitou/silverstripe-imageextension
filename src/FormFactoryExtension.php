<?php
/**
 * FormFactoryExtension adds custom fields to asset-admin Image objects
 *
 * @category Extension
 * @package  ImageExtension
 * @author   Juan Ramón Molina Menor <info@juanmolina.eu>
 * @license  https://opensource.org/licenses/BSD-2-Clause BSD-2
 * @link     https://juanmolina.eu/
 */

namespace Juanitou\ImageExtension;

use SilverStripe\Assets\Image;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\DropdownField;

class FormFactoryExtension extends Extension
{
    public function updateFormFields(FieldList $fields) {
        $fields->insertAfter(
            'Name',
             DropdownField::create(
                'Cropping',
                _t('Juanitou\ImageExtension.CROPPING', '[TODO] Cropping method'),
                Image::singleton()->dbObject('Cropping')->enumValues()
            )
        );
    }
}

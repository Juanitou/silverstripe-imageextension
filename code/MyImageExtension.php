<?php
/**
 * Extends Image objects to provide custom functions
 */
class MyImageExtension extends DataExtension {

	/**
	 * Add a cropping effect switch
	 *
	 * TODO: Translate Enum values
	 * @see http://www.balbus.tk/internationalize#TranslateEnumDropdown
	 */
	public static $db = array (
		'Cropping' => "Enum('Cropped, TopCropped, TODO:BottomCropped', 'Cropped'))"
	);

	public function updateCMSFields(FieldList $fields) {
		$fields->addFieldToTab('Root.Main', new DropdownField(
			'Cropping',
			_t('CROPPING', 'Cropping method'),
			singleton('Image')->dbObject('Cropping')->enumValues())
		);
	}

	/**
	 * Get or generate a top-cropped copy of the image
	 */
	function getTopCroppedImage($width, $height) {
		$cacheFile = $this->owner->cacheFilename("TopCroppedImage", $width, $height);
		if ($this->owner->ID && $this->owner->Filename && Director::fileExists($this->owner->Filename)) {
			if (!Director::fileExists($cacheFile) || isset ($_GET['flush'])) {
				$this->generateTopCroppedImage($width, $height);
			}
			return new Image_Cached($cacheFile);
		}
	}

	/**
	 * Generate a resized copy of the image
	 * with the given width & height and cropped from top-center
	 * @see ExtendedGD.php
	 */
	function generateTopCroppedImage($width, $height) {
		$cacheFile = $this->owner->cacheFilename("TopCroppedImage", $width, $height);
		// You have to work with the absolute file path, at least in WAMP
		$gd = new ExtendedGD(Director::getAbsFile($this->owner->Filename));
		if ($gd->hasGD()) {
			$gd = $gd->topCroppedImage($width, $height);
			if ($gd) {
				$gd->writeTo(Director::getAbsFile($cacheFile));
			}
		}
	}

	/**
	* Get or generate a mirrored copy of the image
	*/
	function getMirroredImage($width, $height) {
		$cacheFile = $this->owner->cacheFilename("MirroredImage", $width, $height);
		if ($this->owner->ID && $this->owner->Filename && Director::fileExists($this->owner->Filename)) {
			if (!Director::fileExists($cacheFile) || isset ($_GET['flush'])) {
				$this->generateMirroredImage($width, $height);
			}
			return new Image_Cached($cacheFile);
		}
	}

	/**
	 * Generate a mirrored copy of the image
	 * by using a custom function
	 * @see ExtendedGD.php
	 */
	function generateMirroredImage($width, $height) {
		$cacheFile = $this->owner->cacheFilename("MirroredImage", $width, $height);
		// You have to work with the absolute file path, at least in WAMP
		$gd = new ExtendedGD(Director::getAbsFile($this->owner->Filename));
		if ($gd->hasGD()) {
			$gd = $gd->mirroredImage($width, $height);
			if ($gd) {
				$gd->writeTo(Director::getAbsFile($cacheFile));
			}
		}
	}
}
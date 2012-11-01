<?php
/**
 * Extends GD objects with custom functions
 */
class ExtendedGD extends GD {
	public function mirroredImage($width, $height) {
		$newGD = imagecreatetruecolor($this->width, $this->height);
		$bg = imagecolorallocatealpha($newGD, 255, 255, 255, 127);
		imagefill($newGD, 0, 0, $bg);
		$dst_x = 0;
		$src_x = 0;

		$coordinate = ($this->height-1);

		foreach (range($this->height, 0) as $range) {
			$src_y = $range;
			$dst_y = $coordinate-$range;
			imagecopy($newGD, $this->gd, $dst_x, $dst_y, $src_x, $src_y, $this->width, 1);
		}

		$output = new GD();
		$output->setGD($newGD);

		$output = $output->croppedResize($width, $height);
		return $output;
	}

	public function topCroppedImage($width, $height) {
		if($this->width / $this->height >= $width/$height) {
			$gd = $gd->resizeByHeigth($height);
			$left = ($gd->resizeByWidth() - $width)/2; //center cropped image.
			// if you want to cut from top left or right make $left = 0 or $gd->getWidth - $width respectively
		} else {
			$gd = $this->resizeByWidth($width);
			$left = 0;
		}
		return $gd->crop(0, $left, $width, $height);
		}

}
<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OutCaptcha;

/**
 * Description of GdImage
 * @author almazko <a.s.suslov@gmail.com>
 */
class GdImage implements Image {

    /**
     * @var int 
     */
    protected $transparentColor;

    /**
     *
     * @param mixed $image Array($width, $height) or path to image
     * @throws Exception 
     */
    public function __construct($image)
    {
        if (is_string($image) && is_file($image)) {
            $this->image = imagecreatefromjpeg($image);
            $this->transparent = imagecolorallocatealpha($this->image, 0, 0, 0, 127);
        } elseif (is_array($image) && count($image) === 2) {
            $this->image = imagecreatetruecolor($image[0], $image[1]);
            $this->transparent = imagecolorallocatealpha($this->image, 0, 0, 0, 127);
            imagefill($this->image, 0, 0, $this->transparent);
        } else {
            throw new Exception();
        }

        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);
        imagealphablending($this->image, true);
    }

    public function addBorder($value, array $color = array(255, 255, 255))
    {
        $borderColor = imagecolorallocate($this->image, $color[0], $color[1], $color[2]);

        $imageWithBorder = imagecreatetruecolor($this->width + $value * 2, $this->height + $value * 2);

        imagefill($imageWithBorder, 0, 0, $borderColor);
        imagecopy($imageWithBorder, $this->image, $value, $value, 0, 0, $this->width, $this->height);

        $this->image = $imageWithBorder;
        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);
        imagealphablending($this->image, true);
    }

    public function resize($value)
    {
        
    }

    public function rotate($angle, array $color = array(55, 255, 255))
    {
        $image = imagerotate($this->image, $angle, $this->transparentColor);
        imagecolortransparent($image, $this->transparentColor);
        $this->image = $image;
        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);
        imagealphablending($this->image, true);
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getInstance()
    {
        return $this->image;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setBackgroundColor(array $color)
    {
        $fillColor = imagecolorallocate($this->image, $color[0], $color[1], $color[2]);
        imagefill($this->image, 0, 0, $fillColor); 
    }

    public function addImage(Image $image, $x, $y)
    {
        imagecopy($this->image, $image->getInstance(), $x, $y, 0, 0, $image->getWidth(), $image->getHeight());
    }

    public function save($path)
    {
        imagesavealpha($this->image, true);
        imagepng($this->image, $path);
    }

    protected function destroy()
    {
        if ($this->image) {
            imagedestroy($this->image);
        }
    }

    public function __destruct()
    {
        $this->destroy();
    }

}

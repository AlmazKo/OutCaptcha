<?php

namespace OutCaptcha;

/**
 * Test class for GdImage.
 * Generated by PHPUnit on 2012-02-26 at 15:13:06.
 */
class GdImageTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test 
     */
    public function constructImageFromArray()
    {
        $image = new GdImage(array(1, 1));

        $this->assertInternalType('resource', $image->getInstance());
    }

    /**
     * @test 
     */
    public function constructImageFromFile()
    {
        $imageFile = __DIR__ . '/images/1x1.jpg';

        $image = new GdImage($imageFile);

        $this->assertInternalType('resource', $image->getInstance());
    }
    
    /**
     * @test 
     * @expectedException OutCaptcha\Exception
     */
    public function constructImageFromWrongData()
    {
        $image = new GdImage(1);
    }

    /**
     * @test 
     */
    public function addBorder()
    {
        $image = new GdImage(array(1, 1));
        
        $image->addBorder(1);
        
        $this->assertEquals(3, $image->getWidth());
        $this->assertEquals(3, $image->getHeight());
    }
    
    /**
     * @test 
     */
    public function setBackgroundColor()
    {
        $image = new GdImage(array(1, 1));
        
        $image->setBackgroundColor(array(10,10,10));
    }
    
    /**
     * @test 
     */
    public function save()
    {
        $image = new GdImage(array(1, 1));
        $path = sys_get_temp_dir() . '/' . uniqid('outCaptcha');
        $image->save($path);
        
        $this->assertTrue(is_file($path));
    }
    
    /**
     * @test 
     */
    public function addImage()
    {
        $image = new GdImage(array(2, 2));
        $addingImage = new GdImage(array(1, 1));
        $image->addImage($addingImage, 1, 1);
    }
    
    /**
     * @test 
     */
    public function rotate()
    {
        $image = new GdImage(array(1, 2));
        $image->rotate(10.0);
    }

}
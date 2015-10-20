<?php

namespace Crew\Unsplash\Tests;

use \Crew\Unsplash as Unsplash;
use \VCR\VCR;

class PhotoTest extends BaseTest
{
	public function setUp()
	{
		parent::setUp();

		$connection = new Unsplash\Connection($this->provider, $this->accessToken);
		Unsplash\HttpClient::$connection = $connection;
	}

	public function testFindPhoto()
	{
		VCR::insertCassette('photos.yml');

		$photo = Unsplash\Photo::find('ZUaqqMxtxYk');

		VCR::eject();

		$this->assertEquals('ZUaqqMxtxYk', $photo->id);
	}

	public function testFindAllPhotos()
	{
		VCR::insertCassette('photos.yml');

		$photos = Unsplash\Photo::all();

		VCR::eject();

		$this->assertEquals(10, $photos->count());
	}

	public function testSearchPhotos()
	{
		VCR::insertCassette('photos.yml');

		$photos = Unsplash\Photo::search('coffee');

		VCR::eject();

		$this->assertEquals(10, $photos->count());
	}

	public function testPhotographer()
	{
		VCR::insertCassette('photos.yml');

		$photo = Unsplash\Photo::find('ZUaqqMxtxYk');
		$photographer = $photo->photographer();

		VCR::eject();

		$this->assertEquals($photo->user['username'], $photographer->username);
	}

	public function testPostPhotos()
	{
		$this->markTestIncomplete(
          'Due to an issue with VCR, we do not run this test.'
        );

		VCR::insertCassette('photos.yml');

		$photo = Unsplash\Photo::create(__dir__.'/images/land-test.txt');

		VCR::eject();

		$this->assertInstanceOf('Photo', $photo);
	}

	public function testRandomPhoto()
	{
		VCR::insertCassette('photos.yml');

		$photo = Unsplash\Photo::random();

		VCR::eject();

		$this->assertEquals('ZUaqqMxtxYk', $photo->id);
	}

	public function testRandomPhotoWithFilters()
	{
		VCR::insertCassette('photos.yml');

		$filters = [
			'category' => [2,3],
			'featured' => true,
			'username' => 'andy_brunner',
			'query'    => 'ice',
			'w'        => 100,
			'h'        => 100
		];

		$photo = Unsplash\Photo::random($filters);

		VCR::eject();

		$this->assertEquals('ZUaqqMxtxYk', $photo->id);
		$this->assertEquals('https://unsplash.imgix.net/photo-1428681756973-d318f055795a?q=75&fm=jpg&w=100&h=100&fit=max&s=b223d24e28ba1ced6731e98d46cd5f83', $photo->urls['custom']);
	}

}

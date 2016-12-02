<?php

namespace Aimeos\Controller\ExtJS\Product\Stock\Type;


/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2016
 */
class StandardTest extends \PHPUnit_Framework_TestCase
{
	private $object;


	protected function setUp()
	{
		$this->object = new \Aimeos\Controller\ExtJS\Product\Stock\Type\Standard( \TestHelperExtjs::getContext() );
	}


	protected function tearDown()
	{
		$this->object = null;
	}


	public function testSearchItems()
	{
		$params = (object) array(
			'site' => 'unittest',
			'condition' => (object) array( '&&' => array( 0 => (object) array( '~=' => (object) array( 'product.stock.type.code' => 'unit' ) ) ) ),
			'sort' => 'product.stock.type.code',
			'dir' => 'ASC',
			'start' => 0,
			'limit' => 1,
		);

		$result = $this->object->searchItems( $params );

		$this->assertEquals( 1, count( $result['items'] ) );
		$this->assertEquals( 5, $result['total'] );
		$this->assertEquals( 'unit_type1', $result['items'][0]->{'product.stock.type.code'} );
	}


	public function testSaveDeleteItem()
	{
		$saveParams = (object) array(
			'site' => 'unittest',
			'items' =>  (object) array(
				'product.stock.type.code' => 'test',
				'product.stock.type.label' => 'label',
				'product.stock.type.status' => 1,
			),
		);

		$searchParams = (object) array(
			'site' => 'unittest',
			'condition' => (object) array( '&&' => array( 0 => (object) array( '==' => (object) array( 'product.stock.type.code' => 'test' ) ) ) )
		);

		$saved = $this->object->saveItems( $saveParams );
		$searched = $this->object->searchItems( $searchParams );

		$deleteParams = (object) array( 'site' => 'unittest', 'items' => $saved['items']->{'product.stock.type.id'} );
		$this->object->deleteItems( $deleteParams );
		$result = $this->object->searchItems( $searchParams );

		$this->assertInternalType( 'object', $saved['items'] );
		$this->assertNotNull( $saved['items']->{'product.stock.type.id'} );
		$this->assertEquals( $saved['items']->{'product.stock.type.id'}, $searched['items'][0]->{'product.stock.type.id'} );
		$this->assertEquals( $saved['items']->{'product.stock.type.code'}, $searched['items'][0]->{'product.stock.type.code'} );
		$this->assertEquals( $saved['items']->{'product.stock.type.label'}, $searched['items'][0]->{'product.stock.type.label'} );
		$this->assertEquals( $saved['items']->{'product.stock.type.status'}, $searched['items'][0]->{'product.stock.type.status'} );
		$this->assertEquals( 1, count( $searched['items'] ) );
		$this->assertEquals( 0, count( $result['items'] ) );
	}
}
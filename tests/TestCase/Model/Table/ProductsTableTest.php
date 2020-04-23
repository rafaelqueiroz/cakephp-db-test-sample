<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductsTable Test Case
 */
class ProductsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductsTable
     */
    protected $Products;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->Products = TableRegistry::getTableLocator()->get('Products');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Products);

        parent::tearDown();
    }

    /**
     * Test save method
     *
     * @return void
     */
    public function testSave(): void
    {
        $count = $this->Products->find()->count();

        $entity = $this->Products->newEntity([
            'name' => 'iPhone 11',
            'slug' => 'iphone-11',
            'price' => 699,
            'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
        ]);

        $this->Products->save($entity);

        $this->assertNotNull($entity->get('id'));
        $this->assertEquals([], $entity->getErrors());
        $this->assertEquals($this->Products->find()->count(), $count + 1);
    }

    /**
     * Test save duplicated method
     *
     * @return void
     */
    public function testSaveDuplicated(): void
    {
        $entity = $this->Products->newEntity([
            'name' => 'iPhone SE',
            'slug' => 'iphone-se',
            'price' => 399,
            'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
        ]);

        $this->Products->save($entity);

        $this->assertNull($entity->get('id'));
        $this->assertArrayHasKey('slug', $entity->getErrors());
        $this->assertEquals(['unique' => 'The provided value is invalid'], $entity->getError('slug'));
    }

}

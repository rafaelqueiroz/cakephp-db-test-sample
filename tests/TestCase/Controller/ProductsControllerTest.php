<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ProductsController;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ProductsController Test Case
 *
 * @uses \App\Controller\ProductsController
 */
class ProductsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Products',
    ];

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->enableCsrfToken();
        $this->enableRetainFlashMessages();

        $this->post('products/add', [
            'name' => 'iPhone 11',
            'slug' => 'iphone-11',
            'price' => 699,
            'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
        ]);

        $this->assertResponseSuccess();
        $this->assertFlashMessage(__('The product has been saved.'));
        $this->assertRedirect('products');
    }

    /**
     * Test add duplicated method
     *
     * @return void
     */
    public function testAddDuplicated(): void
    {
        $this->enableCsrfToken();
        $this->enableRetainFlashMessages();

        $this->post('products/add', [
            'name' => 'iPhone SE',
            'slug' => 'iphone-se',
            'price' => 399,
            'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
        ]);

        $this->assertResponseSuccess();
        $this->assertFlashMessage(__('The product could not be saved. Please, try again.'));
        $this->assertNoRedirect();
    }
    
}

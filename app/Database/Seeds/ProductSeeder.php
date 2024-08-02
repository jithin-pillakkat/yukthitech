<?php

namespace App\Database\Seeds;

use App\Models\Product;
use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $product = new Product();
        $first = $product->find();
        if (empty($first)) {
            $data = [
                [
                    'name' => 'Pen',
                    'code' => 'pen',
                    'price' => 20,
                    'qty' => rand(100, 500)
                ],
                [
                    'name' => 'Pencil',
                    'code' => 'pcl',
                    'price' => 5,
                    'qty' => rand(100, 500)
                ],
                [
                    'name' => 'Notebook',
                    'code' => 'not',
                    'price' => 100,
                    'qty' => rand(100, 500)
                ],
                [
                    'name' => 'Bag',
                    'code' => 'bag',
                    'price' => 1000,
                    'qty' => rand(100, 500)
                ],
                [
                    'name' => 'Umbrella',
                    'code' => 'Umb',
                    'price' => 250,
                    'qty' => rand(100, 500)
                ],
                [
                    'name' => 'Calculator',
                    'code' => 'cal',
                    'price' => 550,
                    'qty' => rand(100, 500)
                ],
                [
                    'name' => 'Water bottle',
                    'code' => 'wat',
                    'price' => 550,
                    'qty' => rand(100, 500)
                ],
            ];
            $product->insertBatch($data);
        }
    }
}

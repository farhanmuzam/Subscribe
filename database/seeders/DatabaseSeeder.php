<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $productData = [
            [
                "name" => "Skin Care Brand Honey",
                "qty" => 10000,
                "description" => "Skin Care dengan bahan alami madu",
                "price" => 99000,
                "photo" => "Three-dimensional-elements-of-honey-skin-care-products-advertising-droplet_126294_wh1200-removebg-preview.png"
            ], [
                "name" => "Shampoo Honey",
                "qty" => 10000,
                "description" => "Shampoo dengan bahan alami madu",
                "price" => 59000,
                "photo" => "shampoo-bottle-isolated-transparent-background_191095-25560-removebg-preview.png"
            ], [
                "name" => "Kosmetik Biru",
                "qty" => 10000,
                "description" => "Paket kosmetik dengan parfum, pelembab, dan sunscreen",
                "price" => 59000,
                "photo" => "pngtree-3d-beauty-cosmetics-product-design-png-image_6391024-removebg-preview.png"
            ], [
                "name" => "Smart Watch",
                "qty" => 10000,
                "description" => "Smart Watch murah dengan gelang berwarna putih",
                "price" => 1500000,
                "photo" => "png-transparent-apple-watch-smartwatch-wearable-technology-apple-products-electronics-gadget-company-removebg-preview.png"
            ], [
                "name" => "Sabun Cuci Muka Pria",
                "qty" => 10000,
                "description" => "Sabun cuci muka yang berfungsi menghilangkan kotoran dan minyak pada muka",
                "price" => 3000,
                "photo" => "283-2839164_professional-cosmetic-product-png-transparent-png-removebg-preview.png"
            ], [
                "name" => "Iphone X",
                "qty" => 500,
                "description" => "Handphone iphone x",
                "price" => 10000000,
                "photo" => "9mgNEn-iphone-starhub-singapore.png"
            ]
        ];

        Product::insert($productData);
    }
}

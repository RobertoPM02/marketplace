<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Product;
use Illuminate\Http\UploadedFile;

final readonly class CreateProduct
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke(null $_, array $args)
    {
        $imagePath = null;

        
        if (isset($args['image']) && $args['image'] instanceof UploadedFile) {
            $imagePath = $args['image']->store('products', 'public');
        }

        return Product::create([
            'name' => $args['name'],
            'price' => $args['price'],
            'image_path' => $imagePath,
        ]);
    }
}
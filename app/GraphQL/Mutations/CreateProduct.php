<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

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
            'stock' => $args['stock'], 
            'image_path' => $imagePath,
            'user_id' => Auth::user()->id,
        ]);
    }
}

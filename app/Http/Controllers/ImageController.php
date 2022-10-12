<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Animal;
use App\Models\Image;
use App\Services\ImageService;

class ImageController extends Controller
{
    /**
     * @var ImageService
     */
    private ImageService $imageService;

    /**
     * @param  ImageService  $imageService
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * @param  Animal  $animal
     * @return ImageResource
     */
    public function index(Animal $animal): ImageResource
    {
        return new ImageResource($animal->images()->without('profile')->get());
    }

    /**
     * @param  Animal  $animal
     * @param  StoreImageRequest  $request
     * @return ImageResource
     */
    public function store(Animal $animal, StoreImageRequest $request): ImageResource
    {
        $path = $this->imageService->upload($request->file('image'));

        $image = new Image();
        $image->setAttribute('path', $path);
        $image->profile()->associate($animal);
        $image->save();

        return new ImageResource($image);
    }

    /**
     * @param  Image  $image
     * @return bool|null
     */
    public function destroy(Image $image): bool|null
    {
        $this->imageService->delete($image->getAttribute('path'));

        return $image->delete();
    }
}

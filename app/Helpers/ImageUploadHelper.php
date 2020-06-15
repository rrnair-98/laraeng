<?php


namespace App\Helpers;


use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class ImageUploadHelper extends BaseFileUploadHelper
{
    private $basePath;
    private $validationRules;
    private const FMT = 'jpg';
    public function __construct(string $basePath, array $validationRules)
    {
        parent::__construct($basePath, $validationRules, self::FMT);
    }

    /**
     * Stores an image on to the disk. Converts all images to jpg as of now
     * @param $image
     * @return string The absolute path
     * @throws \Throwable
     */
    public function store($image){
        $imageValidator = Validator::make(['file' => $image], $this->validationRules);

        throw_if($imageValidator->fails(),  ValidationException::withMessages($imageValidator->errors()->messages()));


        $fileName = hash("sha256", Str::random(15).Carbon::now()->timestamp).".".self::FMT;

        $img = Image::make($image->getRealPath())->encode(self::FMT, 75);
        $img->stream(); // <-- Key point
        $fullPath = $this->basePath.$fileName;
        Storage::disk('public')->put( $fullPath, $img, 'public');
        return Storage::url($fullPath);
    }


}

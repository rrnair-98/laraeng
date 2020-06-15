<?php


namespace App\Helpers;


use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BaseFileUploadHelper
{
    protected $basePath;
    protected $validationRules;
    protected $fmt;

    public function __construct(string $basePath, array $validationRules, string $fmt)
    {
        throw_if($basePath != null && $basePath[strlen($basePath) - 1] != '/', \ErrorException::class, "Illegal path");
        $this->basePath = $basePath;
        $this->validationRules = $validationRules;
        $this->fmt = $fmt;
    }

    public function store($file){
        $validator = Validator::make(["file"=>$file], $this->validationRules);
        throw_if($validator->fails(),  ValidationException::withMessages($validator->errors()->messages()));
        $fileName = hash("sha256", Str::random(15).Carbon::now()->timestamp).".".$this->fmt;
        $fullPath = $this->basePath.$fileName;
        Storage::disk('public')->put( $fullPath, $img, 'public');
        return Storage::url($fullPath);
    }

    /**
     * Deletes the file given in the array at the provided index.
     * @param array $urls The array of urls
     * @param int $index The index to delete
     * @return array|null
     */
    public function deleteWithIndex(array $urls, int $index){
        if ($index >= 0 && $urls != null && $index < count($urls)) {

            $this->delete($urls[$index]);
            unset($urls[$index]);
            return array_values($urls);
        }
        return null;
    }

    /**
     * Deletes the given file path.
     * @param string $filePath
     * @return int|bool
     */
    public function delete($filePath){
        return Storage::disk('local')->delete($filePath);
    }
}

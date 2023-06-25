<?php

namespace PageMaker;

/**
 * @class Image resizer.
 *
 *
 * You can use this class like so:
 * $resizer = new ImageResizer('/path/to/image.jpg');
 * $resizer->resize(100, 100);
 * $resizer->save('/path/to/resized_image.jpg');
 *
 * This is a basic example. A production-level utility might include more features like cropping, rotating, adding
 * watermarks, adjusting brightness/contrast/colors, handling more image types, etc. You may also want to add more
 * error checking and reporting, and consider performance aspects (like memory usage when dealing with large images).
 */
class ImageResizer
{
    private string $imagePath;
    private array $imageInfo;
    private $image;

    public function __construct(string $imagePath)
    {
        if (!file_exists($imagePath)) {
            throw new InvalidArgumentException('Image file does not exist: ' . $imagePath);
        }

        $this->imagePath = $imagePath;
        $this->imageInfo = getimagesize($this->imagePath);
        $this->loadImage();
    }

    private function loadImage(): void
    {
        switch ($this->imageInfo[2]) {
            case IMAGETYPE_JPEG:
                $this->image = imagecreatefromjpeg($this->imagePath);
                break;
            case IMAGETYPE_GIF:
                $this->image = imagecreatefromgif($this->imagePath);
                break;
            case IMAGETYPE_PNG:
                $this->image = imagecreatefrompng($this->imagePath);
                break;
            default:
                throw new InvalidArgumentException('Unsupported image type: ' . $this->imagePath);
        }
    }

    public function resize(int $targetWidth, int $targetHeight): void
    {
        $originalWidth = imagesx($this->image);
        $originalHeight = imagesy($this->image);

        $scaledImage = imagescale($this->image, $targetWidth, $targetHeight);
        if (!$scaledImage) {
            throw new RuntimeException('Failed to resize the image: ' . $this->imagePath);
        }

        $this->image = $scaledImage;
    }

    public function save(string $path): void
    {
        switch ($this->imageInfo[2]) {
            case IMAGETYPE_JPEG:
                imagejpeg($this->image, $path);
                break;
            case IMAGETYPE_GIF:
                imagegif($this->image, $path);
                break;
            case IMAGETYPE_PNG:
                imagepng($this->image, $path);
                break;
            default:
                throw new RuntimeException('Failed to save the image: ' . $path);
        }
    }

    public function __destruct()
    {
        imagedestroy($this->image);
    }
}

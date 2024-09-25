<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RenamePhotos extends Command
{
    // Command signature
    protected $signature = 'photos:rename';

    // Command description
    protected $description = 'Rename photos in /COLAMBUTAN/PHOTO directory';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Define the directory and base filename
        $directory = public_path('/COLAMBUTAN/PHOTO');
        $baseName = 'MO-TUD';
        $extension = '.JPG';

        // Starting and ending number
        $startNumber = 2665;
        $fileCount = 275;  // Total number of files

        // Get all .jpg files in the directory
        $files = File::files($directory);
        $jpgFiles = array_filter($files, function ($file) {
            return strtolower($file->getExtension()) === 'jpg';
        });

        // Sort the files numerically based on the original name (e.g., 1.jpg, 2.jpg, ...)
        usort($jpgFiles, function ($a, $b) {
            return intval(pathinfo($a->getFilename(), PATHINFO_FILENAME)) - intval(pathinfo($b->getFilename(), PATHINFO_FILENAME));
        });

        // Rename each file with an incrementing number from 4959
        foreach ($jpgFiles as $index => $file) {
            $newNumber = $startNumber + $index;
            $newFileName = sprintf('%s-%05d%s', $baseName, $newNumber, $extension);
            $newFilePath = $directory . '/' . trim($newFileName);

            File::move($file->getPathname(), $newFilePath);

            $this->info("Renamed: {$file->getFilename()} to {$newFileName}");
        }

        $this->info('Renaming complete.');
    }
}

<?php

namespace App\Exports;

use App\Models\Shop;
use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class BaseExport
{
    public const FILE_TYPE = 'txt';
    public const BASE_PATH = '../storage/app/public/';

    protected $exportData = null;
    protected $fileName = '';
    protected $filePath = '/';
    protected $lastError = '';

    /**
     * BaseExport constructor.
     */
    public function __construct()
    {
		
    }

    /**
     * @return bool
     */
    protected function makeFile() : bool
    {
        return false;
    }

    /**
     * @return bool
     */
    protected function createFile() : bool
    {
        return false;
    }

    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName) : void
    {
        $clearName = str_replace('/', '_', $fileName);
        $this->fileName = preg_replace('/\.{1,}/','.', $clearName);
    }

    /**
     * @param string $filePath
     */
    public function setFilePath(string $filePath = '') : void
    {
        $this->filePath = preg_replace('/\.{1,}/','_', $filePath);
        if(empty($this->filePath)){
            $this->filePath = '/';
        }
    }

    /**
     * @param ResourceCollection $data
     */
    public function fillData(ResourceCollection &$data) : void
    {
        $this->exportData = $data;
    }

    /**
     * @return string
     */
    public function getFilePath() : string
    {
        return $this->filePath;
    }

    /**
     * @return string
     */
    public function getFileName() : string
    {
        return $this->fileName . '.' . static::FILE_TYPE;
    }
}

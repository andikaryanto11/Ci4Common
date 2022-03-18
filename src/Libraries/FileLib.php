<?php

namespace Ci4Common\Libraries;

use CodeIgniter\HTTP\Files\UploadedFile;
use DateTime;
use DateTimeZone;
use Exception;

class FileLib
{
    protected $filetype = [];
    protected $maxsize;
    protected $urlfile     = '';
    protected $destination = false;
    protected $isUploaded  = false;
    protected $file        = null;

    public $errormsg = '';

    public function __construct($destination, array $filetype = ['jpg', 'jpeg', 'png'], $maxsize = 0)
    {
        if (! $this->destination) {
            $this->destination = $destination;
        }

        $this->filetype = $filetype;
        $this->maxsize  = $maxsize * 1000;
    }

    public function unlink()
    {
        if (! empty($this->getFileUrl()) && $this->isUploaded && file_exists(ROOTPATH . $this->getFileUrl())) {
            unlink(ROOTPATH . $this->getFileUrl());
        }
        return;
    }

    public function upload(UploadedFile $files, $usePrefixName = true, $useHashName = true)
    {
        $this->file = $files;
        if ($this->maxsize !== 0 && $files->getSize() > $this->maxsize) {
            $this->errormsg = 'File Terlalu Besar';
            return false;
        }

        if (! empty($this->filetype)) {
            if (! in_array($this->getFileType(), $this->filetype)) {
                $this->errormsg = 'Format Gambar Tidak Didikung';
                return false;
            }
        }

        // if (!file_exists($this->destination))
        //     mkdir($this->destination, 0755, true, true);
        $nameex = '';
        if ($usePrefixName) {
            $date   = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
            $nameex = $date->format('Ymd_His_');
        }

        if (! $useHashName) {
            $newName = $nameex . str_replace([' ', '#', '+'], ['-', '-', '-'], $files->getName());
        } else {
            $newName = $nameex . md5(uniqid()) . '.' . $files->getExtension();
        }

        if ($files->move(ROOTPATH . $this->destination, $newName)) {
            $this->urlfile    = $this->destination . '/' . $newName;
            $this->isUploaded = true;
            return true;
        }

        return false;
    }

    public function getFileUrl()
    {
        return $this->urlfile;
    }

    public function getErrorMessage()
    {
        return $this->errormsg;
    }

    public function getExtension(UploadedFile $files)
    {
        return pathinfo($files->getExtension(), PATHINFO_EXTENSION);
    }

    public function getFileType()
    {
        return $this->file->getExtension();
    }

    public function getSize()
    {
        return $this->file->getSize();
    }

    public function setExtension($fileType)
    {
        if (is_array($fileType)) {
            $this->filetype = $fileType;
            return $this;
        }

        $this->filetype = [];
        array_push($this->filetype, $fileType);
        return $this;
    }

    public function addExtension($fileType)
    {
        array_push($this->filetype, $fileType);
        return $this;
    }

    public static function removeFile($path)
    {
        if (file_exists($path) && ! is_dir($path)) {
            unlink($path);
        }
    }
}

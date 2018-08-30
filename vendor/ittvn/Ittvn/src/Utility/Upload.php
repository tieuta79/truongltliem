<?php

namespace Ittvn\Utility;

use InvalidArgumentException;
use RuntimeException;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Utility\Hash;
use Cake\Core\Configure;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Routing\Router;
use Ittvn\Utility\Resize;

class Upload {

    /**
     * File post array
     *
     * @var array
     */
    protected $files = array();

    /**
     * Destination directory
     *
     * @var string
     */
    private $upload;

    /**
     * Destination directory resize
     *
     * @var string
     */
    public $pathResize = 'resize';

    /**
     * Max. file size
     *
     * @var int
     */
    protected $max_file_size;

    /**
     * Allowed mime types
     *
     * @var array
     */
    protected $mimes = ['image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png'];

    public function __construct($path = null) {

        if (empty($path)) {
            $path = Configure::read('Settings.Uploads.path');
        }
        $result = $this->dispatchEvent('Upload.path', ['path' => $path]);
        if ($result) {
            $path = $result;
        }

        if (Configure::check('Network')) {
            if (Configure::read('Network.db') == 'default') {
                $path_date = date('Y') . DS . date('m') . DS . date('d');
            } else {
                $folder = explode('_', Configure::read('Network.db'), 2);
                $path_date = $folder[1] . DS . date('Y') . DS . date('m') . DS . date('d');
            }
        } else {
            $path_date = date('Y') . DS . date('m') . DS . date('d');
        }

        /* New Class Upload */
        $type = Configure::read('Settings.Uploads.type');
        $class = '\\Ittvn\Utility\\Upload' . ucfirst($type);
        if (class_exists($class)) {
            $this->upload = new $class($path, $path_date);
        }

        $this->max_file_size = $this->parse_size(ini_get('upload_max_filesize'));

        $this->request = Router::getRequest();
    }

    public function medias($files = [], $path = null) {
        $fileInfos = [];
        if (count($files) > 0) {
            foreach ($files as $file) {
                $fileInfos[] = $this->media($file, $path);
            }
        }
        return $fileInfos;
    }

    public function media($file = [], $path = null) {
        if (empty($file['name']))
            return false;

        if ($this->validFile($file)) {
            $result = $this->dispatchEvent('Upload.media.beforeUpload', ['file' => $file]);
            if ($result) {
                $file = $result;
            }
            $fileInfo = $this->upload->save_file($file);

            $result = $this->dispatchEvent('Upload.media.afterUpload', ['fileInfo' => $fileInfo]);
            if ($result) {
                return $result;
            }
            return $fileInfo;
        }
    }

    public function image($file = [], $path = null) {
        if (empty($file['name']))
            return false;

        if (in_array($file['type'], $this->getMimes())) {
            if ($this->validFile($file)) {
                $result = $this->dispatchEvent('Upload.beforeUpload', ['file' => $file]);
                if ($result) {
                    $file = $result;
                }
                $fileInfo = $this->upload->save_file($file);
                $result = $this->dispatchEvent('Upload.afterUpload', ['fileInfo' => $fileInfo]);
                if ($result) {
                    return $result;
                }
                return $fileInfo;
            }
        } else {
            throw new RuntimeException(sprintf(
                    'Upload not allow file type %s. Please check and upload agian.', $file['type']
            ));
        }
    }

    public function images($files = [], $path = null) {
        $fileInfos = [];
        if (count($files) > 0) {
            foreach ($files as $file) {
                $fileInfos[] = $this->image($file, $path);
            }
        }
        return $fileInfos;
    }

    public function deletes($files = [], $resize = false) {
        if (count($files) > 0) {
            foreach ($files as $file) {
                $this->delete($file, $resize);
            }
        }
    }

    public function delete($file = [], $resize = false) {
        $this->upload->delete($file, $resize);
    }

    public function resizeImages($path, $image, $sizes = []) {
        $return = [];
        if (count($sizes) > 0) {
            foreach ($sizes as $size) {
                $return[] = $this->resizeImage($path, $image, $size);
            }
        }
        return $return;
    }

    public function resizeImage($path, $image, $image_name, $size) {
        $this->upload->resizeImage($path, $image, $image_name, $size);
    }

    private function dispatchEvent($event, $data = []) {
        $event_result = (new EventManager())->dispatch(new Event($event, $data));
        if (!empty($event_result->result)) {
            return $event_result->result;
        }
        return false;
    }

    private function getMimes() {
        $mimes = $this->mimes;
        $event = (new EventManager())->dispatch(new Event('Upload.mimes'));
        if (!empty($event->result)) {
            $mimes = Hash::merge($mimes, $event->result);
        }
        return $mimes;
    }

    private function validFile($file = null) {
        if (!empty($file)) {
            if ($this->checkEror($file['error'])) {
                if ($this->checkSize($file['size'])) {
                    return true;
                }
            }
        }
        return false;
    }

    private function checkSize($size) {
        if ($size <= $this->max_file_size) {
            return true;
        } else {
            throw new RuntimeException(sprintf(
                    __('ittvn', 'File size is limited %s byte in php.'), $this->max_file_size
            ));
            return false;
        }
    }

    private function checkEror($code = 0) {
        switch ($code) {
            case 1:
                throw new RuntimeException(sprintf(
                        __('ittvn', 'File size is limited %s byte in system.'), ini_get('upload_max_filesize')
                ));
                return false;
                break;
            case 2:
                throw new RuntimeException(__('ittvn', 'File size is limited %s byte in browser.'));
                return false;
                break;
            case 3:
                throw new RuntimeException(__('ittvn', 'The uploaded file was only partially uploaded.'));
                return false;
                break;
            case 4:
                throw new RuntimeException(__('ittvn', 'No file was uploaded.'));
                return false;
                break;
            case 6:
                throw new RuntimeException(__('ittvn', 'Missing a temporary folder.'));
                return false;
                break;
            case 7:
                throw new RuntimeException(__('ittvn', 'Failed to write file to disk.'));
                return false;
                break;
            case 8:
                throw new RuntimeException(__('ittvn', 'A PHP extension stopped the file upload.'));
                return false;
                break;
            case 0:
                return true;
                break;
        }
    }

    private function parse_size($size) {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        } else {
            return round($size);
        }
    }

    /**
     * Convert bytes to mb.
     *
     * @param int $bytes
     * @return int
     */
    private function bytesToMb($bytes) {
        return round(($bytes / 1048576), 2);
    }

}

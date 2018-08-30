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

class UploadLocal {

    protected $files = array();

    public $path;
    private $path_date;


    public $pathResize = 'resize';


    protected $max_file_size;


    protected $mimes = ['image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png'];

    public function __construct($path = null, $path_date = null) {
        
        $this->path = $path;
		$this->path_date = $path_date;

        $this->max_file_size = $this->parse_size(ini_get('upload_max_filesize'));

        $this->request = Router::getRequest();
    }
 
    public function save_file($file = null) {
        $infoFile = [];
        if (!empty($file)) {
            $full_path = WWW_ROOT . $this->path . DS . $this->path_date . DS . $file['name'];
            $file['name'] = $this->validFilename($file['name'], $full_path);

            $savefile = new Resize($file['tmp_name']);
            $infoFile['filename'] = $file['name'];
            $infoFile['path'] = WWW_ROOT . $this->path . DS . $this->path_date;
            $infoFile['url'] = $this->request->webroot . $this->path . DS . $this->path_date . DS . $file['name'];
            $infoFile['full_path'] = $full_path;
            $infoFile['size_in_bytes'] = $file['size'];
            $infoFile['size_in_mb'] = $this->bytesToMb($file['size']);
            $infoFile['mime'] = $file['type'];
            
            $savefile->save(WWW_ROOT . $this->path . DS . $this->path_date . DS .$file['name']);
            if (in_array($file['type'], $this->mimes) && Configure::read('Settings.Images.resize') == true) {
                $infoFile['path_resize'] = $infoFile['path'] . DS . $this->pathResize;
                $filenamer = $this->validFilename($file['name'], $infoFile['path'] . DS . $this->pathResize);
                $this->resizeImage($infoFile['path_resize'], $file['tmp_name'], $filenamer, Configure::read('Settings.Images.sizes'));       
            }  
            return $infoFile;            
//            die('aaaa');
//            if (move_uploaded_file($file['tmp_name'], $full_path)) {
//                // return info file uploaded
//                $infoFile['filename'] = $file['name'];
//                $infoFile['path'] = WWW_ROOT . $this->path . DS . $this->path_date;
//                $infoFile['url'] = $this->request->webroot . $this->path . DS . $this->path_date . DS . $file['name'];
//                $infoFile['full_path'] = $full_path;
//                $infoFile['size_in_bytes'] = $file['size'];
//                $infoFile['size_in_mb'] = $this->bytesToMb($file['size']);
//                $infoFile['mime'] = $file['type'];
//                //end return info file uploaded
//                //resize image if config resize = true
//                if (in_array($file['type'], $this->mimes) && Configure::read('Settings.Images.resize') == true) {
//                    $infoFile['path_resize'] = $infoFile['path'] . DS . $this->pathResize;
//                    $this->resizeImage($infoFile['path_resize'], $full_path, Configure::read('Settings.Images.sizes'));
//                }
//                //end resize image if config resize = true
//                return $infoFile;
//            } else {
//                throw new RuntimeException(__('ittvn', 'Can\'t upload file.'));
//            }
        }
        return $infoFile;
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

    public function resizeImage($path, $image, $image_name , $size) {
        
        if (is_string($size) && strpos($size, 'x')) {
            $size = explode('x', $size);
        }
        
        $this->mkpath($path);
        if (count($size) > 0) {            
            $info_image = pathinfo($image_name);              
            $crop = Configure::read('Settings.Images.crop');
            $resize = new Resize($image);
            if($size[0] < $size[1]){
                $resize->resizeToHeight($size[1]);
            }else{
                $resize->resizeToWidth($size[0]);
            }
            
            if ($crop == true) {
                $resize->crop($size[0], $size[1]);
            }
            if (!file_exists($path . DS . $info_image['filename'] . '_' . $size[0] . 'x' . $size[1] . '.' . $info_image['extension'])) {
                $resize->save($path . DS . $info_image['filename'] . '_' . $size[0] . 'x' . $size[1] . '.' . $info_image['extension']);
            }
            return $path . DS . $info_image['filename'] . '_' . $size[0] . 'x' . $size[1] . '.' . $info_image['extension'];
        }
    }

    private function validFilename($filename, $path) {
        if ($this->validPath(WWW_ROOT . $this->path . DS . $this->path_date)) {            
            //$path = WWW_ROOT . $this->path . DS . $this->path_date . DS . $filename;
            if (file_exists($path)) {
                return sha1(mt_rand(1, 9999) . uniqid()) . time() . $filename;
            }
            return $filename;
        } else {
            throw new RuntimeException(__('ittvn', 'Not create path upload.'));
        }
        return false;
    }

    private function validPath($path) {
        $this->mkpath($path);
        $folder = new Folder();
        $folder->chmod($path, 0755, true);
        return true;
    }

    private function mkpath($path) {
        if (@mkdir($path) or file_exists($path))
            return true;
        return ($this->mkpath(dirname($path)) and mkdir($path));
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

    public function delete($file, $resize = false) {
        $count_webroot = strlen($this->request->webroot);
        $path = WWW_ROOT . substr($file, $count_webroot);
        $info_file = pathinfo($path);
        if (unlink($path)) {
            if ($resize == true) {
                $path_resize = $info_file['dirname'] . DS . $this->pathResize;

                $dir = new Folder($path_resize);
                $resize_files = $dir->find('^' . $info_file['filename'] . '_.*\.' . $info_file['extension']);
                foreach ($resize_files as $resize_file) {
                    unlink($path_resize . DS . $resize_file);
                }
            }
            return true;
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
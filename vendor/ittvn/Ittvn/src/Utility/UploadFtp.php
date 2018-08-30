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
use Settings\Utility\Setting;


class UploadFtp {

    protected $files = array();

    public $path;
    private $path_date;
    public $pathResize = 'resize';
    protected $max_file_size;
    protected $mimes = ['image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png'];
    
    public $ftp_server;
    public $ftp_server_port;
    public $ftp_user_name;
    public $ftp_user_pass;
    private $conn;
    public $errors;    

    public function __construct($path = null, $path_date = null) {
        $settings = new Setting();
        $this->ftp_server = $settings->getOption('Uploads.ftpHost');
        $this->ftp_server_port = $settings->getOption('Uploads.ftpPort');
        $this->ftp_user_name = $settings->getOption('Uploads.ftpUser');
        $this->ftp_user_pass = $settings->getOption('Uploads.ftpPass');
        
        $this->path = $path;
		$this->path_date = $path_date;

        $this->max_file_size = $this->parse_size(ini_get('upload_max_filesize'));

        $this->request = Router::getRequest();
        $this->connect();
        
    }
    
    private function connect(){
        $this->conn = ftp_connect($this->ftp_server, $this->ftp_server_port); 
        ftp_pasv($this->conn, true);
        $login_result = ftp_login( $this->conn, $this->ftp_user_name, $this->ftp_user_pass);
        if(!$login_result){
            $this->errors[] = 'Error connect ftp';
        }
    }
    
    public function save_file($file = null){
        $infoFile = [];
        if (!empty($file)) {
            $file['name'] = $this->validFilename($file['name']);
            $full_path = WWW_ROOT . $this->path . DS . $this->path_date . DS . $file['name'];
            // return info file uploaded
            $infoFile['filename'] = $file['name'];
            $infoFile['path'] = WWW_ROOT . $this->path . DS . $this->path_date;
            $infoFile['url'] = $this->request->webroot . $this->path . DS . $this->path_date . DS . $file['name'];
            $infoFile['full_path'] = $full_path;
            $infoFile['size_in_bytes'] = $file['size'];
            $infoFile['size_in_mb'] = $this->bytesToMb($file['size']);
            $infoFile['mime'] = $file['type'];
            //end return info file uploaded
            $remote_file = $this->path . DS . $this->path_date. DS . $file['name'];
            ftp_put($this->conn, $remote_file, $file['tmp_name'], FTP_BINARY);
            //resize image if config resize = true
            if (in_array($file['type'], $this->mimes) && Configure::read('Settings.Images.resize') == true) {
                $infoFile['path_resize'] = $this->path . DS . $this->path_date. DS . $this->pathResize;                
                $this->resizeImage($infoFile['path_resize'], $file['tmp_name'], $file['name'], Configure::read('Settings.Images.sizes'));
            }
            //end resize image if config resize = true
            ftp_close($this->conn);
        }
        return $infoFile;
    }
    
    public function mkpath($ftpath){
        $origin = ftp_pwd($this->conn); 
        if(@ftp_chdir($this->conn, $ftpath)){  
            ftp_chdir($this->conn, $origin);
            return true;
        }else{            
            if($this->mkpath(dirname($ftpath)) && ftp_mkdir($this->conn, $ftpath)){
                ftp_chmod($this->conn, 0777, $ftpath);
                return true;
            }            
            return false;
        }
    }
    
    public function delete($file, $resize = false) {
        if (ftp_delete($this->conn, $file)) {            
            return true;
        }
        ftp_close($this->conn);
        return false;
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
        if (!empty($size)) {
            $info_image = pathinfo($image);
            $crop = Configure::read('Settings.Images.crop');
            $resize = new Resize();
            $resize->prepare($image);
            if ($crop == true) {
                $resize->crop($size[0], $size[1]);
            } else {
                if ($info_image['extension'] == 'png') {
                    $resize->resizePng($size[0], $size[1]);
                } else {
                    $resize->resize($size[0], $size[1]);
                }
            }

            if (!file_exists($path . DS . $info_image['filename'] . '_' . $size[0] . 'x' . $size[1] . '.' . $info_image['extension'])) {
                $resize->save($path . DS . $info_image['filename'] . '_' . $size[0] . 'x' . $size[1] . '.' . $info_image['extension']);
            }
            return $path . DS . $info_image['filename'] . '_' . $size[0] . 'x' . $size[1] . '.' . $info_image['extension'];
        }
    }

    private function validFilename($filename) {
        if ($this->validPath($this->path . DS . $this->path_date)) {
            ftp_chmod($this->conn, 0777, $this->path);
            $path = $this->path . DS . $this->path_date . DS . $filename;
            if ($this->fileExits($path)) {                
                return sha1(mt_rand(1, 9999) . uniqid()) . time() . $filename;
            }
            return $filename;
        } else {
            throw new RuntimeException(__('ittvn', 'Not create path upload.'));
        }
        return false;
    }
    private function fileExits($path){
        $files = ftp_nlist($this->conn, $path);
        if(in_array($path, $files)){
            return true;
        }
        return false;
    }

    private function validPath($path) {
        $this->mkpath($path);
        return true;
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

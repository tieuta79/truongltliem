<?php    
set_time_limit(300);//for setting 
$path='/'.date('dmY').'';
$ftp_server='192.168.1.200';
$ftp_server_port="21";
$ftp_user_name='s2s';
$ftp_user_pass="ittvn123";

// set up a connection to ftp server
$conn_id = ftp_connect($ftp_server, $ftp_server_port); 
// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

// check connection and login result
if ((!$conn_id) || (!$login_result)) { 
    echo "Chua ket noi</br>";
} else {
    echo "Da ket noi</br>";
    // enabling passive mode
    ftp_pasv( $conn_id, true );
    // get contents of the current directory
    $contents = ftp_rawlist($conn_id, "-al ".$dir_name);    // list thu muc
    // output $contents
    var_dump($contents);
}
// close the FTP connection
ftp_close($conn_id);

// function Creates a directory
$dir = 'newfolder';
$conn_id = ftp_connect($ftp_server, $ftp_server_port); 
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

if (ftp_mkdir($conn_id, $dir)) {
 echo "Da tao duoc file $dir\n</br>";
} else {
 echo "Khong tao duoc file $dir\n</br>";
}

// function Upload file

$file = "123415.txt";//tobe uploaded 
$remote_file = "123415.txt";
if(!file_exists($file)) echo "File khong ton tai</br>"; // kiem tra file ton tai

// turn passive mode on
ftp_pasv($conn_id, true);

// try to upload $file
if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {  // upload file
    echo "Da up $file\n";
} else {
    echo "Khong up duoc $file\n";
}

// close the connection and the file handler
ftp_close($conn_id);





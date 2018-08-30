<?php

include 'httpsocket.php';

$sock = new HTTPSocket;

$sock->connect('ittvn.com', 2222);
//$sock->set_login('admin','keQV7W9bPw07@#nghia$vas');
$sock->set_login('truonghoc', 'ittvn123');

$sock->set_method('POST');

/*
  $result = $sock->query('/CMD_API_DOMAIN_POINTER', array(
  'domain' => 'truonghocketnoi.vn',
  'action' => 'add',
  'from' => "c1tvuong-nt.khanhhoa.edu.vn",
  'alias' => 'yes'
  ));
 */
/*
  $result = $sock->query('/CMD_API_DOMAIN_POINTER', array(
  'domain' => 'truonghocketnoi.vn',
  'list' => 'c1tvuong-nt.khanhhoa.edu.vn'
  ));
 */
/*
  $result = $sock->query('/CMD_API_DOMAIN_POINTER', array(
  'domain' => 'truonghocketnoi.vn',
  'action'=>'delete',
  'select0'=>'c1tvuong-nt.khanhhoa.edu.vn'
  ));
 * 
 */
sleep(5);
print_r($result);
/*
  $sock->query('/CMD_API_SHOW_ALL_USERS');
  $result = $sock->fetch_parsed_body();
  print_r($result);
 */
?>
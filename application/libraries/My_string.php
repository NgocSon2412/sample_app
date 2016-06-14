<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class My_string {

    public function some_function(){
    }
	public function fullurl(){
      $ssl      = (isset($_SERVER['HTTPS']) && ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' )?true:false;
      $sp       = strtolower( $_SERVER['SERVER_PROTOCOL'] );
      $protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
      $port     = $_SERVER['SERVER_PORT'];
      $port     = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
      $host     = (isset($use_forwarded_host) && isset( $_SERVER['HTTP_X_FORWARDED_HOST'] ) ) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : ( isset( $_SERVER['HTTP_HOST'] ) ? $_SERVER['HTTP_HOST'] : null );
      $host     = isset( $host ) ? $host : $_SERVER['SERVER_NAME'] . $port;
      return $protocol . '://' . $host . $_SERVER['REQUEST_URI'];
  }
}

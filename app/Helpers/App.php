<?php
  /**
   *
   */
  namespace App\Helpers;
  use App\Helpers\App;
  use Session;
  use Redirect;
  use View;
  use File;

  class App
  {
    public static function generateID(){
      $charset  = 'ABCDEFGHIJKLMNOPRSTUZ';
      $letters  = substr(str_shuffle($charset),0,3);
      $code     = $letters.mt_rand(10000000,99999999);

      return $code;
    }

    public static function generateUniqueID(){
      $uid = md5(uniqid());
      return substr($uid, 0, 25);
    }

    public static function getFileName($file, $name, $path){
      $origin = $file->getClientOriginalName();
      $originalName = pathinfo($origin, PATHINFO_FILENAME);
      $extension = $file->getClientOriginalExtension();
      $filename = $name.'_'.date('d_m_Y_His').'.'.$extension;

      return $filename;
    }

    public static function generatePassword() {
      $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
      $password = array();
      $alphaLength = strlen($alphabet) - 1;
      for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $password[] = $alphabet[$n];
      }
      return implode($password);
    }

    public static function generatePasswordHash($password){
      $salt = App::generateSalt();

      $options = [
          'salt' => $salt,
          'cost' => 10
      ];

      return password_hash($password, PASSWORD_DEFAULT, $options);
    }

    private static function generateSalt(){
      $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789/\\][{}\'";:?.>,<!@#$%^&*()-_=+|';
      $randStringLen = 64;

      $randString = "";
      for ($i = 0; $i < $randStringLen; $i++) {
         $randString .= $charset[mt_rand(0, strlen($charset) - 1)];
      }

      return $randString;
    }

    public static function getToken(){
      return Session::token();;
    }

    public static function getLevelMessage($user, $level){
      $msg = '';
      switch ($level) {
        case 1:
          $msg = 'Akun dengan NIP '.$user->nip.' berhasil dirubah menjadi Staff.';
          break;
        default:
          $msg = 'Akun dengan NIP '.$user->nip.' berhasil dirubah menjadi Admin.';
          break;
      }

      return $msg;
    }

    public static function getStatusMessage($user, $status){
      $msg = '';
      switch ($status) {
        case 1:
          $msg = 'Akun dengan NIP '.$user->nip.' berhasil diaktifkan.';
          break;
        case 2:
          $msg = 'Akun dengan NIP '.$user->nip.' berhasil dinonaktifkan.';
          break;
      }

      return $msg;
    }

    public static function deleteUser($user){
      $isSuccess = false;
      if(File::exists($user->foto)){
        $isSuccess = App::deleteProfile($user);
      }
      return $isSuccess;
    }

    private static function deleteProfile($user){
      if($user->foto != 'img/profile.jpg'){
        File::delete($user->foto);
      }
      return $user->delete();
    }

    public static function formatDateTime($date){
      $dateTime = date_create($date);
      return date_format($dateTime, "d/m/Y H:i:s");
    }

    public static function formatDate($date){
      $dateTime = date_create($date);
      return date_format($dateTime, "d/m/Y");
    }

    public static function getTodaysDateTime(){
      return date("d/m/Y H:i:s");
    }
  }

?>

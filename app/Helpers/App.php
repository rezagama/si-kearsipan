<?php
  /**
   *
   */
  namespace App\Helpers;
  use App\Helpers\App;
  use App\Kategori;
  use App\Arsip;
  use Session;
  use Redirect;
  use View;
  use File;
  use URL;

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

    public static function isValueNull($val){
      if($val == ''){
        return $val = null;
      }
      return $val;
    }

    public static function getDocumentStatus($folder){
      $parent = $folder->parent;
      $status = $folder->nama_kategori;

      while ($parent != null) {
        $parent = Kategori::where('id_kategori', $parent)->first();
        $status = $parent->nama_kategori;
        $parent = $parent->parent;
      }

      switch ($status) {
        case 'Arsip Aktif':
          return 1;
          break;
        case 'Arsip Inaktif':
          return 2;
          break;
        case 'Arsip Statis':
          return 3;
          break;
        case 'Arsip Dimusnahkan':
          return 0;
          break;
        default:
          return 4;
          break;
      }
    }

    public static function getDocumentPath($folder){
      $path = array();
      $parent = $folder->parent;

      $data = array(
        'title' => $folder->nama_kategori,
        'url' => URL::route('arsip.show', $folder->id_kategori)
      );

      array_push($path, $data);

      while ($parent != null) {
        $parent = Kategori::where('id_kategori', $parent)->first();

        $data = array(
          'title' => $parent->nama_kategori,
          'url' => URL::route('arsip.show', $parent->id_kategori)
        );

        array_push($path, $data);

        $parent = $parent->parent;
      }

      return $path;
    }

    public static function getArchivePath($folder){
      $path = array();
      $parent = $folder->parent;

      $data = array(
        'title' => $folder->nama_kategori,
        'url' => $folder->id_kategori
      );

      array_push($path, $data);

      while ($parent != null) {
        $parent = Kategori::where('id_kategori', $parent)->first();

        $data = array(
          'title' => $parent->nama_kategori,
          'url' => $parent->id_kategori
        );

        array_push($path, $data);

        $parent = $parent->parent;
      }

      return $path;
    }

    public static function getArchiveRoot($folder){
      $root = $folder->nama_kategori;
      $parent = $folder->parent;

      while ($parent != null) {
        $parent = Kategori::where('id_kategori', $parent)->first();
        $root = $parent->nama_kategori;
        $parent = $parent->parent;
      }

      return $root;
    }

    public static function getArchiveRootId($folder){
      $root = $folder->id_kategori;
      $parent = $folder->parent;

      while ($parent != null) {
        $parent = Kategori::where('id_kategori', $parent)->first();
        $root = $parent->id_kategori;
        $parent = $parent->parent;
      }

      return $root;
    }

    public static function getArchiveRootType($folder){
      $root = $folder->tipe_kategori;
      $parent = $folder->parent;

      while ($parent != null) {
        $parent = Kategori::where('id_kategori', $parent)->first();
        $root = $parent->tipe_kategori;
        $parent = $parent->parent;
      }

      return $root;
    }

    public static function copyArchiveFolder($folder, $root){
      $status = $root->tipe_kategori;
      $parent = $folder->parent;
      $id = App::generateUniqueID();
      $archive = App::getArchiveRoot($folder);
      $kategori = Kategori::where('nama_kategori', $folder->nama_kategori)
                                ->where('root', $root->id_kategori)->first();

      if(!$kategori){
        $kategori = new Kategori;
        $kategori->id_kategori = $id;
        $kategori->nama_kategori = $folder->nama_kategori;
        $kategori->tipe_kategori = $status;
        $kategori->root = $root->id_kategori;
        $kategori->save();
      } else {
        $id = $kategori->id_kategori;
      }

      while ($parent != null) {
        $parent = Kategori::where('id_kategori', $parent)->first();
        $name = $parent->nama_kategori;

        if($name != $archive){
          $kategori = Kategori::where('nama_kategori', $name)
                                  ->where('root', $root->id_kategori)->first();
          if(!$kategori){
            $kategori = new Kategori;
            $kategori->id_kategori = App::generateUniqueID();
            $kategori->nama_kategori = $name;
            $kategori->tipe_kategori = $status;
            $kategori->root = $root->id_kategori;
            $kategori->save();
          }
        }

        $parent = $parent->parent;
      }
      App::setFolderParent($folder, $root);
      return $id;
    }

    public static function setFolderParent($folder, $root){
      $status = $root->tipe_kategori;
      $parent = $folder->parent;
      $archive = App::getArchiveRoot($folder);
      $kategori = Kategori::where('nama_kategori', $folder->nama_kategori)
                              ->where('root', $root->id_kategori)->first();

      while ($parent != null) {
        $parent = Kategori::where('id_kategori', $parent)->first();
        $name = $parent->nama_kategori;

        if($name != $archive){
          $parents = Kategori::where('nama_kategori', $name)
                                ->where('root', $root->id_kategori)->first();

          $kategori->parent = $parents->id_kategori;
          $kategori->save();

          $nextparent = Kategori::where('id_kategori', $parent->parent)->first();
          if($nextparent->parent == null){
            $parents->parent = $root->id_kategori;
            $parents->save();
          }
        }

        $kategori = Kategori::where('nama_kategori', $parent->nama_kategori)
                              ->where('root', $root->id_kategori)->first();
        $parent = $parent->parent;
      }
    }

    public static function getCategoryType($parent){
      if($parent != null){
        $folder = Kategori::where('id_kategori', $parent)->first();
        $parent = App::getArchiveRootType($folder);
      } else {
        $parent = 4;
      }

      return $parent;
    }

    public static function removeCategory($kategori){
      $delete = FALSE;
      $archive = Kategori::where('id_kategori', $kategori->id_kategori)->first();

      while($archive){
        $arsip = Arsip::where('id_kategori', $archive->id_kategori)->get();
        foreach ($arsip as $key => $data) {
          App::deleteArsip($data);
        }
        $archive = Kategori::where('parent', $archive->id_kategori)->first();
      }

      while ($kategori) {
        $delete = $kategori->delete();
        $kategori = Kategori::where('parent', $kategori->id_kategori)->first();
      }

      return $delete;
    }

    public static function getPathCount($path){
      $i = 0;
      foreach ($path as $key => $value) {
        $i++;
      }
      return $i - 1;
    }

    public static function deleteUser($user){
      $isSuccess = false;
      if(File::exists($user->foto)){
        $isSuccess = App::deleteProfile($user);
      }
      return $isSuccess;
    }

    public static function deleteArsip($arsip){
      if(File::exists($arsip->file)){
        File::delete($arsip->file);
      }
      return $arsip->delete();
    }

    public static function hapusFileArsip($arsip){
      if(File::exists($arsip->file)){
        File::delete($arsip->file);
      }
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
      $dateTime = strtotime(strtr($date, '/', '-'));
      return date("Y/m/d", $dateTime);
    }

    public static function dbFormatDate($date){
      $dateTime = date_create(strtotime($date));
      return date_format($dateTime, "Y-m-d");
    }

    public static function getTodaysDateTime(){
      return date("d/m/Y H:i:s");
    }
  }

?>

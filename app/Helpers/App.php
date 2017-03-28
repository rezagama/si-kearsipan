<?php
  /**
   *
   */
  namespace App\Helpers;
  use Carbon\Carbon;
  use App\Helpers\App;
  use App\Direktori;
  use App\Riwayat;
  use App\Arsip;
  use App\Log;
  use Redirect;
  use Session;
  use Auth;
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

    public static function getUserStatus($status){
      switch ($status) {
        case 1:
          $status = 'mengaktifkan';
          break;
        case 2:
          $status = 'menonaktifkan';
          break;
      }

      return $status;
    }

    public static function getUserRole($level){
      switch ($level) {
        case 1:
          $level = 'Staff';
          break;

        default:
          $level = 'Admin';
          break;
      }
      return $level;
    }

    public static function isValueNull($val){
      if($val == ''){
        return $val = null;
      }
      return $val;
    }

    public static function getDocumentStatus($folder){
      $parent = $folder->parent;
      $status = $folder->nama_direktori;

      while ($parent != null) {
        $parent = Direktori::where('id_direktori', $parent)->first();
        $status = $parent->nama_direktori;
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
        'title' => $folder->nama_direktori,
        'url' => URL::route('arsip.show', $folder->id_direktori)
      );

      array_push($path, $data);

      while ($parent != null) {
        $parent = Direktori::where('id_direktori', $parent)->first();

        $data = array(
          'title' => $parent->nama_direktori,
          'url' => URL::route('arsip.show', $parent->id_direktori)
        );

        array_push($path, $data);

        $parent = $parent->parent;
      }

      return $path;
    }

    public static function saveSystemLog($data){
      $option = $data['option'];

      $log = new Log;
      $log->id_log = App::generateUniqueID();
      $log->id_user = Auth::user()->id_user;
      $log->deskripsi = $data['deskripsi'];
      $log->url = $data['url'];
      $log->tipe = App::getLogType($option);
      $save = $log->save();

      if($option == 'arsip' && $data['url'] != null){
        $riwayat = new Riwayat;
        $riwayat->id_arsip = $data['url'];
        $riwayat->id_log = $log->id_log;
        $riwayat->save();
      }

      return $save;
    }

    public static function getLogType($option){
      $logtype = 1;
      switch ($option) {
        case 'arsip':
          $logtype = 1;
          break;
        case 'akun':
          $logtype = 2;
          break;
        case 'direktori':
          $logtype = 3;
          break;
        case 'user':
          $logtype = 4;
          break;
        default:
          $logtype = 0;
          break;
      }
      return $logtype;
    }

    public static function getArchivePath($folder){
      $path = array();
      $parent = $folder->parent;

      $data = array(
        'title' => $folder->nama_direktori,
        'url' => $folder->id_direktori
      );

      array_push($path, $data);

      while ($parent != null) {
        $parent = Direktori::where('id_direktori', $parent)->first();

        $data = array(
          'title' => $parent->nama_direktori,
          'url' => $parent->id_direktori
        );

        array_push($path, $data);

        $parent = $parent->parent;
      }

      return $path;
    }

    public static function getArchiveRoot($folder){
      $root = $folder->nama_direktori;
      $parent = $folder->parent;

      while ($parent != null) {
        $parent = Direktori::where('id_direktori', $parent)->first();
        $root = $parent->nama_direktori;
        $parent = $parent->parent;
      }

      return $root;
    }

    public static function getArchiveRootId($folder){
      $root = $folder->id_direktori;
      $parent = $folder->parent;

      while ($parent != null) {
        $parent = Direktori::where('id_direktori', $parent)->first();
        $root = $parent->id_direktori;
        $parent = $parent->parent;
      }

      return $root;
    }

    public static function getArchiveRootType($folder){
      $root = $folder->tipe_direktori;
      $parent = $folder->parent;

      while ($parent != null) {
        $parent = Direktori::where('id_direktori', $parent)->first();
        $root = $parent->tipe_direktori;
        $parent = $parent->parent;
      }

      return $root;
    }

    public static function copyArchiveFolder($folder, $root){
      $status = $root->tipe_direktori;
      $parent = $folder->parent;
      $id = App::generateUniqueID();
      $archive = App::getArchiveRoot($folder);
      $direktori = Direktori::where('nama_direktori', $folder->nama_direktori)
                          ->where('root', $root->id_direktori)->first();

      if(!$direktori){
        $direktori = new Direktori;
        $direktori->id_direktori = $id;
        $direktori->nama_direktori = $folder->nama_direktori;
        $direktori->tipe_direktori = $status;
        $direktori->root = $root->id_direktori;
        $direktori->save();
      } else {
        $id = $direktori->id_direktori;
      }

      while ($parent != null) {
        $parent = Direktori::where('id_direktori', $parent)->first();
        $name = $parent->nama_direktori;

        if($name != $archive){
          $direktori = Direktori::where('nama_direktori', $name)
                              ->where('root', $root->id_direktori)->first();
          if(!$direktori){
            $direktori = new Direktori;
            $direktori->id_direktori = App::generateUniqueID();
            $direktori->nama_direktori = $name;
            $direktori->tipe_direktori = $status;
            $direktori->root = $root->id_direktori;
            $direktori->save();
          }
        }

        $parent = $parent->parent;
      }
      App::setFolderParent($folder, $root);
      return $id;
    }

    public static function setFolderParent($folder, $root){
      $status = $root->tipe_direktori;
      $parent = $folder->parent;
      $archive = App::getArchiveRoot($folder);
      $direktori = Direktori::where('nama_direktori', $folder->nama_direktori)
                              ->where('root', $root->id_direktori)->first();

      $direktori->parent = $root->id_direktori;
      $direktori->save();

      while ($parent != null) {
        $parent = Direktori::where('id_direktori', $parent)->first();
        $name = $parent->nama_direktori;

        if($name != $archive){
          $parents = Direktori::where('nama_direktori', $name)
                                ->where('root', $root->id_direktori)->first();

          $direktori->parent = $parents->id_direktori;
          $direktori->save();

          $nextparent = Direktori::where('id_direktori', $parent->parent)->first();
          if($nextparent->parent == null){
            $parents->parent = $root->id_direktori;
            $parents->save();
          }
        }

        $direktori = Direktori::where('nama_direktori', $parent->nama_direktori)
                              ->where('root', $root->id_direktori)->first();
        $parent = $parent->parent;
      }
    }

    public static function getCategoryType($parent){
      if($parent != null){
        $folder = Direktori::where('id_direktori', $parent)->first();
        $parent = App::getArchiveRootType($folder);
      } else {
        $parent = 4;
      }

      return $parent;
    }

    public static function removeCategory($direktori){
      $delete = FALSE;
      $archive = Direktori::where('id_direktori', $direktori->id_direktori)->first();

      while($archive){
        $arsip = Arsip::where('id_direktori', $archive->id_direktori)->get();
        foreach ($arsip as $key => $data) {
          App::deleteArsip($data);
        }
        $archive = Direktori::where('parent', $archive->id_direktori)->first();
      }

      while ($direktori) {
        $delete = $direktori->delete();
        $direktori = Direktori::where('parent', $direktori->id_direktori)->first();
      }

      return $delete;
    }

    public static function formatLocalDate($date, $format){
      $idx = Carbon::parse($date)->format('w');
      $day = Carbon::parse($date)->format('d');
      $month = Carbon::parse($date)->format('n');
      $year = Carbon::parse($date)->format('Y');

      $hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu");
      $bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

      switch ($format) {
        case 'l, d M Y':
          $date = $hari[$idx].', '.$day.' '.$bulan[$month].' '.$year;
          break;

        default:
          $date = $day.' '.$bulan[$month].' '.$year;
          break;
      }

      return $date;
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

    public static function hapusFoto($user){
      if(File::exists($user->foto)){
        File::delete($user->foto);
      }
    }

    public static function trimText($text, $limit) {
      if (str_word_count($text, 0) > $limit) {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          $text = substr($text, 0, $pos[$limit]) . '...';
      }
      return $text;
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

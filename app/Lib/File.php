<?php

namespace App;

use App\Helpers\Url;
use App\Models\User;
use yii\base\BaseObject;
use yii\base\Exception;
use yii\web\UploadedFile;

/**
 * Класс по работе с публичными и приватными файломи
 */
class File extends BaseObject
{
    const PREFIX_CROP   = '_crop';
    const PREFIX_RESIZE = '_resize';

    const DEFAULT_EXT = 'png';

    const SUBDOMAIN_COUNT = 6;


    /**
     * Домен с файлами, задаётся в конфиге
     * @var string
     */
    protected $domainPublic;

    /**
     * Флаг, находимся мы в продакшене или нет
     * @var boolean
     */
    protected $inProduction;

    /**
     * @param string $domainPublic
     */
    public function setDomainPublic($domainPublic)
    {
        $this->domainPublic = $domainPublic;
    }

    /**
     * @param boolean $inProduction
     */
    public function setInProduction($inProduction)
    {
        $this->inProduction = $inProduction;
    }

    /**
     * @return string
     */
    public function getDomainPublic()
    {
        return $this->domainPublic;
    }

    /**
     * @return boolean
     */
    public function inProduction()
    {
        return $this->inProduction;
    }

    /**
     * для статики
     * @return string
     */
    protected function getStaticDomainTemplate()
    {
        return App::i()->getConfig()->getStaticDomainTemplate();
    }

    /**
     * Для аута
     */
    protected function getFilesDomain()
    {
        return App::i()->getConfig()->getFilesDomain();
    }

    /**
     * @return string
     */
    public function getPathToPublic()
    {
        return App::i()->getConfig()->getPathToPublicStatic();
    }

    /**
     * @return string
     */
    public function getPathToPrivate()
    {
        return App::i()->getConfig()->getPathToPrivateStatic();
    }

    /**
     * @return string
     */
    public function getPublicDir()
    {
        return App::i()->getConfig()->getPublicDir();
    }

    public function movePublic($old_filename, $new_filename) {
        $old_path = self::getBaseDirectory($this->getPathToPublic() . DIRECTORY_SEPARATOR, $old_filename);
        $new_path = self::getBaseDirectory($this->getPathToPublic() . DIRECTORY_SEPARATOR, $new_filename);

        return rename($old_path . $old_filename, $new_path . $new_filename);
    }

    /**
     * @param UploadedFile $file
     * @param int          $type
     * @param int          $entity_id
     *
     * @return CpaFile
     * @throws Exception
     */
    public function upload(UploadedFile $file, $type, $entity_id = 0) {
        if (!in_array($type, array_keys(CpaFile::typeList()))) {
            throw new Exception('Unknown file type');
        }

        /**
         * туда же в классы отдать и ресайзы, кропы и прочую дрочь, будет заебись
         */

        if (CpaFile::typeIsPublic($type)) {
            /** uploadPublic() используется в куче моделе переделать на upload() */
            list($filename, $extension) = $this->uploadPublic($file);
        } else {
            list($filename, $extension) = $this->uploadPrivate($file);
        }

        if ($type == CpaFile::TYPE_OFFER_IMAGE) {
            list($filename, $extension) = $this->resizePublic($filename . '.' . $extension, 145, 60);
        } elseif ($type == CpaFile::TYPE_STOCK_IMAGE) {
            list($filename, $extension) = $this->resizePublic($filename . '.' . $extension, 210, 150);
        }

        $current_user_id = App::i()->getCurrentUser() ? App::i()->getCurrentUser()->id : null;

        $new_file = new CpaFile();

        $new_file->type        = $type;
        $new_file->name        = $filename;
        $new_file->ext         = $extension;
        $new_file->origin_name = $file->name;
        $new_file->size        = $file->size;
        $new_file->user_id     = $current_user_id;
        $new_file->entity_id   = $entity_id;
        $new_file->mime_type   = $file->type;

        $new_file->save();

        return $new_file;
    }

    /**
     * Сохраняет публичный файл
     *
     * @param  UploadedFile $file
     *
     * @return bool|array
     */
    public function uploadPublic(UploadedFile $file)
    {
        if (!empty($file->error)) {
            return false;
        }

        $filename     = $this->generateMd5($file->name);
        $extension    = $this->getExtension($file);
        $filename_ext = $filename . '.' . $extension;

        $path_to_save = self::getBaseDirectory($this->getPathToPublic() . DIRECTORY_SEPARATOR, $filename_ext);
        $file->saveAs($path_to_save . $filename_ext);

        return [$filename, $extension];
    }

    /**
     * Сохраняет приватный файл, записывает данные в cpa_files
     *
     * @param  UploadedFile $file
     *
     * @return array|bool
     */
    public function uploadPrivate($file)
    {
        if (!empty($file->error)) {
            return false;
        }

        $filename     = $this->generateMd5($file->name);
        $extension    = $this->getExtension($file);
        $filename_ext = $filename . '.' . $extension;

        $path_to_save = self::getBaseDirectory($this->getPathToPrivate() . DIRECTORY_SEPARATOR, $filename_ext);
        $file->saveAs($path_to_save . $filename_ext);

        return [$filename, $extension];
    }

    /**
     * Сохраняет измененный файл
     *
     * @param string $filename_ext
     * @param int    $width
     * @param int    $height
     *
     * @return array
     */
    public function resizePublic($filename_ext, $width, $height)
    {
        self::resizeFile($filename_ext, (int)$width, (int)$height);
        $name = $this->getNameByNameFile($filename_ext);
        return [$name . self::PREFIX_RESIZE, self::DEFAULT_EXT];
    }

    /**
     * Сохраняет обрезанный файл
     *
     * @param string $filename_ext
     * @param array  $params
     *
     * @return array
     */
    public function cropPublic($filename_ext, $params)
    {
        if (empty($params)) {
            $params = [];
        }
        self::cropFile($filename_ext, json_encode($params));
        $name = $this->getNameByNameFile($filename_ext);
        return [$name . self::PREFIX_CROP,  self::DEFAULT_EXT];
    }

    /**
     * @param CpaUser $user
     * @param $id
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function deletePrivate(CpaUser $user, $id)
    {
        /** @var CpaFile $file_model */
        $file_model = CpaFile::findOne($id);
        if (!$file_model) {
            return false;
        }
        if (!$file_model->isDeletableByUser($user)) {
            return false;
        }
        if (!$file_model->delete()) {
            return false;
        }
        return true;
    }

    /**
     * Удаление публичного файла из файловой системы
     *
     * @param CpaFile $file
     *
     * @return bool
     *
     */
    public function deletePublicFile(CpaFile $file)
    {
        $path_to_file = $this->getPathPublicToFile($file->name . '.' . $file->ext);
        return $this->deleteFile($path_to_file);
    }

    /**
     * Удаление приватного файла из файловой системы
     *
     * @param CpaFile $file_model
     *
     * @return bool
     */
    public function deletePrivateFile(CpaFile $file_model)
    {
        $path_to_file = $this->getPathPrivateToFile($file_model->name . '.' . $file_model->ext);
        return $this->deleteFile($path_to_file);
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    protected function deleteFile($path)
    {
        if (file_exists($path)) {
            return unlink($path);
        }
        return true;
    }

    /**
     * @param CpaFile $file
     *
     * @return string
     */
    public function getPathToFile(CpaFile $file)
    {
        if ($file->isPublic()) {
            return $this->getPathPublicToFile($file->name . '.' . $file->ext);
        } else {
            return $this->getPathPrivateToFile($file->name . '.' . $file->ext);
        }
    }

    /**
     * @param $file null array
     * @return string
     */
    public function getPathToDownloadFile($file)
    {
        if(empty($file)) {
            return false;
        }

        if(CpaFile::typeIsPublic($file['type'])) {
            return $this->getPathPublicToFile($file['name'] . '.' . $file['ext']);
        } else {
            return $this->getPathPrivateToFile($file['name'] . '.' . $file['ext']);
        }
    }

    /**
     * Получение пути для публичного файла
     *
     * @param string $filename_ext Имя файла с расширением
     *
     * @return string
     */
    public function getPathPublicToFile($filename_ext)
    {
        return $this->getPathToPublic() . DIRECTORY_SEPARATOR . self::getPathSub($filename_ext, false) . $filename_ext;
    }

    /**
     * Получение пути для приватного файла
     *
     * @param string $filename_ext Имя файла с расширением
     *
     * @return string
     */
    public function getPathPrivateToFile($filename_ext)
    {
        return $this->getPathToPrivate() . DIRECTORY_SEPARATOR . self::getPathSub($filename_ext, false) . $filename_ext;
    }

    /**
     * Вычисляет имя поддомена по имени файла
     *
     * @param string $filename -- имя файла
     *
     * @return string
     */
    public function getSubdomain($filename)
    {
        $index = ord($filename) % self::SUBDOMAIN_COUNT + 1;
        return str_replace('%i', $index, $this->getStaticDomainTemplate());
    }

    /**
     * Получение урла до публичного файла на морде
     *
     * @param string $filename_ext Имя файла с разширением
     * @param bool   $for_out      Флаг (для аута или для морды)
     * @param string $key_out      Ключ юзера
     *
     * @return string
     */
    public function getUrlPublic($filename_ext, $for_out = false, $key_out = null)
    {
        if ($for_out) {
            return $this->getFilesDomain() . ($key_out ? '/' . $key_out . '/' : '/') . self::getPathSub($filename_ext) . $filename_ext;
        }

        $domain = $this->inProduction ? self::getSubdomain($filename_ext) : '';
        return $domain . '/' . $this->getPublicDir() . '/' . self::getPathSub($filename_ext) . $filename_ext;
    }


    /**
     * Получение урла до публичного файла на морде для подсчета просмотра промо
     *
     * @param string $filename_ext Имя файла с разширением
     * @param string $key_out      key_out Юзера
     *
     * @return string
     */
    public function getUrlForPromo($filename_ext, $key_out)
    {
        return $this->domainPublic . '/' . $key_out . '/' . self::getPathSub($filename_ext) . $filename_ext;
    }

    /**
     * Multi Domain Url -- отдает статический контент с разных поддоменов.
     * Для использования во вьюхах:
     * @example File::imgUrl('/bs3style/icons/actions.ico') --> 'http://st2.hotfix.7img.ru/bs3style/icons/actions.ico'
     *
     * @param string $filename --  имя файла (можно с путем)
     *
     * @return string
     */
    public function mdUrl($filename)
    {
        if (!$this->inProduction) {
            return App::i()->getConfig()->getFaceDomain() . $filename;
        }
        $only_name = basename($filename);
        return $this->getSubdomain($only_name) . $filename;
    }

    /**
     * Получение урла на скачивание приватного файла
     *
     * @param CpaFile $file_model
     *
     * @return string
     */
    public static function getUrlDownloadPrivate(CpaFile $file_model)
    {
        return Url::toRoute(['/file', 'id' => $file_model->id]);
    }

    /**
     * Получение урла до приватного файла
     *
     * @param CpaFile $file_model
     *
     * @return string
     */
    public static function getUrlPreviewPrivate(CpaFile $file_model)
    {
        return Url::toRoute(['/file/show', 'id' => $file_model->id]);
    }

    /**
     * Получение подпапки для файла
     *
     * @param string $filename
     * @param bool   $for_url
     *
     * @return string
     */
    protected static function getPathSub($filename, $for_url = true)
    {
        $ds = $for_url ? '/' : DIRECTORY_SEPARATOR;
        return substr($filename, 0, 2) . $ds . substr($filename, 2, 2) . $ds;
    }

    /**
     * Генерация уникального имени
     *
     * @param mixed $file
     *
     * @return string
     */
    protected function generateMd5($file)
    {
        return md5(microtime() . $file);
    }

    /**
     * Возвращает название по
     *
     * @param $filename_ext
     *
     * @return string
     */
    public function getNameByNameFile($filename_ext)
    {
        return pathinfo($filename_ext, PATHINFO_FILENAME);
    }

    /**
     * Получает расширение файла
     *
     * @param UploadedFile|string $file
     *
     * @return string
     */
    public function getExtension($file)
    {
        $ext = mb_strtolower(pathinfo($file, PATHINFO_EXTENSION), 'UTF-8');
        return $ext != 'jpeg' ? $ext : 'jpg';
    }


    /**
     * Изменяем размер файла
     *
     * @param string $filename_ext
     * @param int    $width
     * @param int    $height
     */
    protected function resizeFile($filename_ext, $width, $height)
    {
        $path_to_file   = $this->getPathPublicToFile($filename_ext);
        $name_file      = $this->getNameByNameFile($filename_ext) . self::PREFIX_RESIZE . '.' . self::DEFAULT_EXT;
        $path_to_resize = $this->getPathPublicToFile($name_file);

        self::resizeGDImage($path_to_file, $path_to_resize, $width, $height);
    }

    /**
     * Обрезаем файл
     *
     * @param string $filename_ext
     * @param string $params
     */
    public function cropFile($filename_ext, $params)
    {
        $params    = json_decode($params, true);
        $path      = $this->getPathSub($filename_ext);
        $name_file = $this->getNameByNameFile($filename_ext) . self::PREFIX_CROP . '.' .self::DEFAULT_EXT;

        if ($params['width'] > 0 && $params['height'] > 0) {
            self::resizeGDImage(
                $path . $filename_ext,
                $path . $name_file,
                $params['width'],
                $params['height'],
                [
                    $params['x'],
                    $params['y'],
                    $params['width'],
                    $params['height'],
                ]
            );
        }
    }

    /**
     * @param string     $source      путь к оригинальной картинке
     * @param string     $destination путь куда сохранять
     * @param int        $dst_width   новая ширина
     * @param int        $dst_height  новая высота
     * @param null|array $crop        массив координат и сторон для обрезки картинки
     */
    public static function resizeGDImage($source, $destination, $dst_width, $dst_height, $crop = null)
    {
        $image_info = getimagesize($source);

        if ($image_info) {
            $ext = $image_info[2];
        } else {
            $ext = IMAGETYPE_PNG;
        }

        if ($ext == IMAGETYPE_JPEG) {
            $im = imagecreatefromjpeg($source);
        } elseif ($ext == IMAGETYPE_GIF) {
            $im = imagecreatefromgif($source);
        } else {
            $im = imagecreatefrompng($source);
        }

        $width  = imagesx($im);
        $height = imagesy($im);

        $thumb_w = $dst_width;
        $thumb_h = $dst_height;

        if (!$crop) {
            $source_aspect_ratio    = $width / $height;
            $thumbnail_aspect_ratio = $dst_width / $dst_height;

            if ($width <= $dst_width && $height <= $dst_height) {
                $thumb_w = $width;
                $thumb_h = $height;
            } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
                $thumb_w = (int)($dst_height * $source_aspect_ratio);
                $thumb_h = $dst_height;
            } else {
                $thumb_w = $dst_width;
                $thumb_h = (int)($dst_width / $source_aspect_ratio);
            }
        }

        $newImg = imagecreatetruecolor($thumb_w, $thumb_h);

        if ($ext == IMAGETYPE_PNG || $ext == IMAGETYPE_GIF) {
            imagealphablending($newImg, false);
            imagesavealpha($newImg, true);
            $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
            imagefilledrectangle($newImg, 0, 0, $width, $height, $transparent);
        }

        if (!is_array($crop)) {
            imagecopyresampled($newImg, $im, 0, 0, 0, 0, $thumb_w, $thumb_h, $width, $height);
        } else {
            imagecopyresampled($newImg, $im, 0, 0, $crop[0], $crop[1], $dst_width, $dst_height, $crop[2], $crop[3]);
        }

        ImagePng($newImg, $destination);
        imagedestroy($newImg);
    }

    /**
     * @param string $base_dir
     * @param string $filename_ext
     *
     * @return string
     */
    protected static function getBaseDirectory($base_dir = '', $filename_ext)
    {
        $dir1 = substr($filename_ext, 0, 2);
        $dir2 = substr($filename_ext, 2, 2);

        $base_dir .= $dir1 . DIRECTORY_SEPARATOR;

        if (!file_exists($base_dir)) {
            mkdir($base_dir);
        }

        $base_dir .= $dir2 . DIRECTORY_SEPARATOR;
        if (!file_exists($base_dir)) {
            mkdir($base_dir);
        }
        return $base_dir;
    }

    /**
     * @param $file
     *
     * @return array|bool
     * @throws Exception
     */
    public function getImageSize($file)
    {
        if ($file instanceof CpaFile) {
            $path_to_file = $this->getPathPublicToFile($file->getFullName());
        } elseif ($file instanceof UploadedFile) {
            $path_to_file = $file->tempName;
        } elseif (is_string($file)) {
            $path_to_file = $file;
        } else {
            throw new Exception('Wrong usage');
        }

        return getimagesize($path_to_file);
    }
}

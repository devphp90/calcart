<?php

class Utils
{

    /**
     * Get path of the data folder using for view files
     */
    public static function dataViewPath($subPath = '')
    {
        return poa('app.widgets._data' . (empty($subPath) ? '' : ".{$subPath}"));
    }

    /**
     * Get a sub-set of an array by keys
     * @param array $array original array
     * @param array $keys sub-set keys
     */
    public static function subArrayByKeys($array, $keys)
    {
        $tmpArray = array();
        if (is_array($array) && is_array($keys)) {
            foreach ($keys as $key)
                $tmpArray[$key] = $array[$key];
        }
        return $tmpArray;
    }

    /**
     * Ajax validation for a specific form
     */
    public static function ajaxValidation($model, $formId = '')
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $formId) {
            echo CActiveForm::validate($model);
            app()->end();
        }
    }

    /**
     * An extend method for the built-in md5
     * @return string 32 bytes string
     */
    public static function md5($str)
    {
        if ($str)
            $str = md5($str . param('salt'));
        return $str;
    }

    /**
     * Get path to a specific upload folder
     * @param string $subPath
     */
    public static function uploadPath($subPath = null)
    {
        $path = poa('www') . '/upload/';
        return empty($subPath) ? $path : ($path . $subPath);
    }

    public static function uploadPathBackend($subPath = null)
    {
        $path = poa('www') . '/upload/';
        return empty($subPath) ? $path : ($path . $subPath);
    }

    /**
     * Get path to a specific upload folder
     * @param string $subPath
     */
    public static function uploadHashPath($userId = null, $subPath = null)
    {
        $path = poa('www') . '/upload/';
        if (!is_null($userId))
            $path .= Utils::calcHashPath($userId) . '/';
        return empty($subPath) ? $path : ($path . $subPath);
    }

    /**
     * Get tmp upload path
     */
    public static function uploadTmpPath($subPath = null)
    {
        return self::uploadPath('tmp/' . $subPath);
    }

    /**
     * Get upload url
     */
    public static function uploadUrl($subPath = null)
    {
        $url = app()->request->getHostInfo() . '/upload/';
        return empty($subPath) ? $url : ($url . $subPath);
    }

    /**
     * Get upload url
     */
    public static function uploadHashUrl($userId = null, $subPath = null)
    {
        $url = app()->request->getHostInfo() . '/upload/';
        if (!is_null($userId))
            $url .= Utils::calcHashPath($userId) . '/';
        return empty($subPath) ? $url : ($url . $subPath);
    }

    /**
     * Get tmp upload url
     */
    public static function uploadTmpUrl($subPath = null)
    {
        return self::uploadUrl('tmp/' . $subPath);
    }

    /**
     * createThumb function
     * @param type $path
     * @param type $fileName
     * @param type $size
     * @param type $bgColor
     */
    public static function createThumb($path, $fileName, $size, $bgColor = '222222')
    {
        $desPath = $path . '/' . $size;
        @mkdir($desPath, 0777, true);

        if (!class_exists('phpThumb', false)) {
            Yii::import("application.vendors.phpThumb.*");
            require_once("phpthumb.class.php");
        }

        $size = explode('x', $size);
        $realPath = realpath($path . '/' . $fileName);

        $thumbGenerator = new phpThumb();
        $thumbGenerator->setSourceFilename($realPath);
        $thumbGenerator->setParameter('w', $size[0]);
        $thumbGenerator->setParameter('h', $size[1]);
        //$thumbGenerator->setParameter('bg', $bgColor);
        //$thumbGenerator->setParameter('far', 'C');

        if ($thumbGenerator->GenerateThumbnail()) {
            $thumbGenerator->RenderToFile($desPath . '/' . $fileName);
        } else {
//            dump($thumbGenerator);
        }
    }

    /**
     * Clear all uploaded files in sessions
     */
    public static function resetUploadFiles()
    {
        user()->setState('uploadFiles', null);
    }

    /**
     * Create thumb files with sizes configured in params.php
     */
    public static function createThumbFiles($source, $path, $thumb, $autoPath = true)
    {
        if ($autoPath)
            $path = Utils::uploadPath($path);

        if (!is_dir($path)) {
            @mkdir($path, 0777, true);
        }

        $sizes = param('thumb', $thumb);
        if (!empty($sizes)) {
            foreach ($sizes as $size) {
                Utils::createThumb($path, $source, $size);
            }
        }
    }

    /**
     * Delete original file and its thumb files
     */
    public static function deleteFiles($rootPath, $fileName, $thumb = '')
    {
        $sizes = array();
        @unlink($rootPath . '/' . $fileName);
        if (!empty($thumb)) {
            $sizes[] = param('thumbs', $thumb);
        } else {
            $allThumbs = param('thumbs');
            foreach ($allThumbs as $thumbs)
                $sizes[] = $thumbs;
        }
        
        if (!empty($sizes)) {
            foreach ($sizes as $size) {
                @unlink($rootPath . '/' . $size . '/' . $fileName);
            }
        }
    }

    /**
     * Cut string by length and space
     */
    public static function cutString($str, $len, $more = '')
    {
        $tmpStr = trim($str);
        if (!empty($tmpStr) && strlen($tmpStr) >= $len) {
            $str = substr($tmpStr, 0, $len);

            if (substr_count($str, " ")) {
                while (strlen($str) && ($str[strlen($str) - 1] != " ")) {
                    $str = substr($str, 0, -1);
                }
                $str = substr($str, 0, -1);
            }
            if ($more)
                $str .= " " . $more;
        }
        return $str;
    }

    public static function cutHtmlString($str, $len, $more = '')
    {
        $output = new HtmlCutString($str, $len);
        $result = $output->cut();
        if ($more && strlen($str) > strlen($result))
            $result .= " " . $more;
        $result = str_replace('<body>', '', $result);
        $result = str_replace('</body>', '', $result);
        return $result;
    }

    public static function generateUrl($title, $format = '-')
    {
        // Convert accented characters, and remove parentheses and apostrophes
        $from = explode(',', "ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,(,),[,],'");
        $to = explode(',', 'c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,,,,,,');

        // Do the replacements, and convert all other non-alphanumeric characters to spaces
        $title = preg_replace('~[^\w\d]+~', '-', str_replace($from, $to, trim($title)));

        // Remove a - at the beginning or end and make lowercase
        $str = strtolower(preg_replace('/^-/', '', preg_replace('/-$/', '', $title)));
        if ($format != '-') {
            return str_replace('-', '', $str);
        } else {
            return $str;
        }
    }

    public static function createFriendlyUrl($str, $options = array())
    {
        // Make sure string is in UTF-8 and strip invalid UTF-8 characters
        $str = mb_convert_encoding((string) $str, 'UTF-8', mb_list_encodings());

        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => false,
        );

        // Merge options
        $options = array_merge($defaults, $options);

        $char_map = array(
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
            'ß' => 'ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
            'ÿ' => 'y',
            // Latin symbols
            '©' => '(c)',
            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',
            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
            'Ž' => 'Z',
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z',
            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
            'Ż' => 'Z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',
            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z'
        );

        // Make custom replacements
        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

        // Transliterate characters to ASCII
        if ($options['transliterate']) {
            $str = str_replace(array_keys($char_map), $char_map, $str);
        }

        // Replace non-alphanumeric characters with our delimiter
        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

        // Remove duplicate delimiters
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

        // Truncate slug to max. characters
        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

        // Remove delimiter from ends
        $str = trim($str, $options['delimiter']);

        return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }

    public static function calcHashPath($id)
    {
        if ($id > 999999999)
            die("id flow!");
        $formatted = sprintf("%09d", $id);
        return wordwrap($formatted, 3, "/", 1);
    }

    public static function getStatusOptions($full = false)
    {
        $data = array(
            ActiveRecord::STATUS_ACTIVE => 'Active',
            ActiveRecord::STATUS_DEACTIVE => 'In Active',
        );
        if ($full)
            $data[ActiveRecord::STATUS_DELETE] = 'Deleted';
        return $data;
    }

    /**
     * @desc remove folder
     * @param type $dir
     */
    public static function removeDir($dir, $rmRoot = true)
    {
        foreach (glob($dir . '/*') as $file) {
            if (is_dir($file))
                self::removeDir($file);
            else
                unlink($file);
        }
        if ($rmRoot)
            rmdir($dir);
    }

    /**
     *
     * Create a folder if it not exist
     * @param string $path
     */
    public static function mkdir($path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
            chmod($path, 0777);
        }
    }

    public static function copyFolder($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ( $file = readdir($dir))) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if (is_dir($src . '/' . $file)) {
                    Utils::copyFolder($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    public static function generageKey($text)
    {
        if (Utils::isNullOrEmptyString($text)) {
            throw new InvalidArgumentException('text');
        }

        $char_map = array(
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
            'ß' => 'ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
            'ÿ' => 'y',
            // Latin symbols
            '©' => '(c)',
            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',
            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
            'Ž' => 'Z',
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z',
            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
            'Ż' => 'Z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',
            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z',
            //Vietnamese
            'á' => 'a', 'à' => 'a', 'ả' => 'a', 'ã' => 'a', 'ạ' => 'a', 'â' => 'a', 'ấ' => 'a', 'ầ' => 'a',
            'ẩ' => 'a', 'ẫ' => 'a', 'ậ' => 'a', 'ă' => 'a', 'ắ' => 'a', 'ằ' => 'a', 'ẳ' => 'a', 'ẵ' => 'a',
            'ặ' => 'a', 'é' => 'e', 'è' => 'e', 'ẻ' => 'ẽ', 'ẹ' => 'e', 'ê' => 'e', 'ề' => 'e', 'ễ' => 'e',
            'ẽ' => 'e', 'ế' => 'e', 'ể' => 'e', 'ệ' => 'e', 'í' => 'i', 'ì' => 'i', 'ỉ' => 'i', 'ĩ' => 'i',
            'ị' => 'i', 'ú' => 'u', 'ù' => 'u', 'ủ' => 'u', 'ũ' => 'u', 'ụ' => 'u', 'ư' => 'u', 'ứ' => 'u',
            'ừ' => 'u', 'ử' => 'u', 'ữ' => 'u', 'ự' => 'u', 'ó' => 'o', 'ò' => 'o', 'ỏ' => 'o', 'õ' => 'o',
            'ọ' => 'o', 'ô' => 'o', 'ố' => 'o', 'ồ' => 'o', 'ổ' => 'o', 'ỗ' => 'o', 'ộ' => 'o', 'ơ' => 'o',
            'ớ' => 'o', 'ờ' => 'o', 'ở' => 'o', 'ỡ' => 'o', 'ợ' => 'o', 'ý' => 'y', 'ỳ' => 'y', 'ỷ' => 'y',
            'ỹ' => 'y', 'ỵ' => 'y'
        );

        $result = strtolower($text);
        $result = str_replace('ð', 'đ', $result);

        $result = str_replace(array_keys($char_map), $char_map, $text);
        $result = preg_replace('([^0-9a-zA-Z\-]+)', '-', $result);

        return strtolower(rtrim($result, '-'));
    }

    public static function isNullOrEmptyString($question)
    {
        return (!isset($question) || trim($question) === '');
    }

    public static function deleteSponsorThumb($fileName)
    {
        $path = explode('/', $fileName);
        $count = count($path);
        $root = Utils::uploadPath(implode('/', array($path[$count - 5], $path[$count - 4], $path[$count - 3], $path[$count - 2])));
        $sponsorThumb = param('thumb', 'sponsor');

        $areas = SponsorsArea::model()->findAll();

        foreach ($areas as $area) {
            $thumb = $root . '/' . $area->width . 'x' . $area->height . '/' . $path[$count - 1];
            if (is_file($thumb))
                unlink($thumb);
        }
    }

    public static function getSiteInfo()
    {
        static $info = array();

        if (empty($info)) {
            $domain = str_replace('www.', '', $_SERVER['HTTP_HOST']);
            $site = Site::model()->findByDomain($domain);
            if (!$site) {
                $domainParts = explode('.', $domain);
                $site = Site::model()->findByDomain(str_replace($domainParts[0] . '.', '', $domain));
                if ($site) {
                    $horse = Horse::model()->find('site_id =:site_id AND sub_domain =:sub_domain', array(':site_id' => $site->id, ':sub_domain' => $domainParts[0]));
                    if ($horse) {
                        $info['horseId'] = $horse->id;
                        $info['horseName'] = $horse->name;
                        $info['horseDomain'] = $domainParts[0];
                    }
                }
            }

            if ($site) {
                $info['siteId'] = $site->id;
                $info['siteName'] = $site->site_title;
                $info['domain'] = $site->domain;

                $social = ContactPage::model()->find('site_id = ' . $site->id);
                $info['social']['facebook'] = $info['social']['twitter'] = "";
                if ($social) {
                    $info['social']['facebook'] = $social->facebook;
                    $info['social']['twitter'] = $social->twitter;
                }
            } else {
                $info['domain'] = $domain;
            }
        }

        return $info;
    }

    public static function getFolderOfSource($source)
    {
        $arr = explode('/', $source);
        unset($arr[count($arr) - 1]);
        return implode('/', $arr);
    }

    public static function downloadFile($id)
    {
        $file = File::model()->findByPk($id);
        if ($file) {
            $filePath = Utils::uploadPath($file->source);
            if (file_exists($filePath)) {
                // attachment exists
                header('Cache-Control: public');
                header('Content-type: ' . mime_content_type($filePath));
                header('Content-Disposition: attachment; filename="' . date('Y-m-d') . '_' . $file->name . '"');
                readfile($filePath);
                die();
            } else {
                die("Error: File not found.");
            }
        }
    }

    /**
     * Delete character special and get word from description
     * @param type $row
     * @param type $word_nb
     * @return string 
     */
    public static function clearTag($text, $word_nb = null)
    {

        $text = preg_replace('/{([a-zA-Z0-9\-_]*)\s*(.*?)}/i', '', $text);
        $text = str_replace('&nbsp;', ' ', $text);
        $text = htmlspecialchars(strip_tags($text));

        //  neu co word_nb va lon hon moi chay
        if ($word_nb) {
            $text_arr = explode(" ", $text);
            if (count($text_arr) > intval($word_nb)) {
                $text = implode(" ", array_slice($text_arr, 0, $word_nb)) . '...';
            }
        }

        return $text;
    }

    /**
     * Get first image from article 
     * @param type $row
     * $param type $imgDefault name example 'default.png'
     * @return type 
     */
    public static function getImgsrc($text, $imgDefault = '')
    {

        $regex = "/<img[^>]+src\s*=\s*[\"']\/?([^\"']+)[\"'][^>]*\>/";

        preg_match($regex, $text, $matches);

        $images = (count($matches)) ? $matches : array();

        if (empty($images)) {
            $image = FALSE;
        } else {
            $image = $images[1];
        }
        return $image;
    }

    public static function getConfiguration($siteId, $name)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'site_id = :siteId AND name = :name';
        $criteria->params = array(':siteId' => $siteId, ':name' => $name);

        $config = Configuration::model()->find($criteria);

        return (!empty($config) ? $config->value : 'Not set');
    }

    public static function checkSiteModule($siteId, $moduleKey)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'site_id = :siteId AND module_id IN (SELECT id FROM modules WHERE `key` = :key)';
        $criteria->params = array(
            ':siteId' => $siteId,
            ':key' => $moduleKey,
        );
        $result = UserModule::model()->find($criteria);

        return !empty($result);
    }

    public static function getStaticPage($siteId, $curPage)
    {
        $staticPages = param('staticPage');
        $data = array();
        $criteria = new CDbCriteria();
        $criteria->condition = 'site_id = :siteId AND type = :type AND static_page = :page';
        $criteria->params = array(
            ':type' => PostType::TYPE_PAGE,
            ':siteId' => $siteId,
        );

        if (!empty($curPage)) {
            $criteria->condition .= ' AND static_page != :curPage';
            $criteria->params[':curPage'] = $curPage;
        }

        foreach ($staticPages as $key => $page) {
            $criteria->params[':page'] = $key;
            $staticPage = PostType::model()->find($criteria);
            if (!$staticPage)
                $data[$key] = $page;
        }

        return $data;
    }

    public static function getListDay()
    {
        $data = array();

        for ($i = 1; $i < 32; $i++)
            $data[$i] = $i;

        return $data;
    }

    public static function getListMonth()
    {
        $data = array();

        for ($i = 1; $i <= 12; $i++)
            $data[$i] = date('M', mktime(0, 0, 0, $i, 1, 2011));

        return $data;
    }

    public static function getListYear()
    {
        $data = array();

        for ($i = date('Y'); $i > 1960; $i--)
            $data[$i] = $i;

        return $data;
    }

    public static function renderFormField($form, $competitionResultField, $key)
    {
        switch ($competitionResultField->field->type) {
            case CompetitionField::TYPE_DROPDOWN:
            case CompetitionField::TYPE_RADIO:
                $temp = explode('|', $competitionResultField->field->name);
                $tempDatas = array();
                if (!empty($temp[1])) {
                    $array = explode(':', $temp[1]);
                    for ($index = 0; $index < count($array); $index++) {
                        $value = trim($array[$index]);
                        $tempDatas[$value] = $value;
                    }
                }
                if ($competitionResultField->field->type == CompetitionField::TYPE_DROPDOWN)
                    echo '<label class="select">' . $form->dropDownList($competitionResultField, "[$key]value", $tempDatas, array('class' => 'select-control')) . '</label>';
                else
                    echo $form->radioButtonList($competitionResultField, "[$key]value", $tempDatas, array('labelOptions' => array('style' => 'float: left; margin-right: 20px;'), 'separator' => ''));
                break;
            case CompetitionField::TYPE_AREA:
                echo $form->textArea($competitionResultField, "[$key]value", array('class' => 'textarea-control'));
                break;
            case CompetitionField::TYPE_CHECKBOX:
                echo $form->checkBox($competitionResultField, "[$key]value");
                break;
            case CompetitionField::TYPE_DATE:
                app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $competitionResultField,
                    'attribute' => "[$key]value",
                    'value' => "[$key]value",
                    'options' => array(
                        'showAnim' => 'fold',
                        'showButtonPanel' => true,
                        'autoSize' => true,
                        'dateFormat' => 'yy-mm-dd',
                        'defaultDate' => "[$key]value",
                    ),
                    'htmlOptions' => array(
                        'class' => 'input-control',
                    )
                ));
                break;
            default:
                echo $form->textField($competitionResultField, 'value', array('class' => 'input-control', 'name' => "CompetitionResultField[$key][value]"));
                break;
        }
    }

    public static function getHorseYear($date)
    {
        $month = date("m");
        $year = date("Y", strtotime($date));
        $date = date("Y-m-d", mktime(0, 0, 0, "08", "01", $year));
        $now = date("Y-m-d");
        $ret = $now - $date;

        if ($month < 8) {
            return $ret - 1;
        } else {
            return $ret;
        }
    }

    public static function sortdate($a, $b)
    {
        return($b['race_date'] - $a['race_date']);
    }

    public static function changeDate($ary)
    {
        // declare $ret variable, turn on error_reporting when developing
        $ret = array();

        if (is_array($ary)) {
            foreach ($ary as $k => $v) {
                $ret[$k] = $v;
                $d = explode("/", $v['race_date']);
                $date = $d[2] . '-' . $d[1] . '-' . $d[0];
                $ret[$k]['race_date'] = strtotime($date);
                $ret[$k]['site_title'] = "";
            }
        }
        return $ret;
    }

    public static function generateUsername($username)
    {
        for ($i = 1; $i < 99999999999; $i++) {
            $temp = $username;
            $temp .= $i;
            $userExist = User::model()->findByAttributes(array('username' => $temp));
            if (empty($userExist)) {
                return $temp;
            }
        }

        return '';
    }

}

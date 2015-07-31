<?php namespace Rabble\Support;

class IO
{

    /**
     * Force a string of data to be downloaded as a file
     *
     * @param string $name
     * @param string $data
     *
     * @return string|void
     */
    public static function forceDataDownload($name, $data)
    {
        $name_parts = explode('.', $name);
        $extension = array_pop($name_parts);

        // TODO support more extensions
        switch ($extension) {
            case 'csv':
                $content_type = 'application/csv';
                break;
            default:
                $content_type = 'application/octet-stream';
        }

        if (function_exists('mb_strlen')) {
            $file_size = mb_strlen($data, '8bit');
        } else {
            $file_size = strlen($data);
        }

        header('Content-Description: File Transfer');
        header('Content-Type: '.$content_type);
        header('Content-Disposition: attachment; filename="'.$name.'"');
        header('Content-Length: '.$file_size);

        echo $data;
    }

    /**
     * Force a file to be downloaded
     *
     * @param $full_file_path
     *
     * @return string|void
     * @throws \Exception
     */
    public static function forceFileDownload($full_file_path)
    {
        $file_path_parts = explode('/', $full_file_path);
        $file_name = array_pop($file_path_parts);

        try {
            $contents = readfile($full_file_path);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return self::forceDataDownload($file_name, $contents);
    }

}

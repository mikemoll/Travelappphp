<?php

/**
 * Modelo da classe Mensagem
 * @filesource
 * @author 		Leonardo Daneili
 * @copyright 	Leonardo Danieli
 * @package		sistema
 * @subpackage	sistema.apllication.models
 * @version		1.0
 */
class DBUpdate {

    function __construct() {
        $this->sqlFolder = RAIZ_DIRETORY . 'res/db_updates';
    }

    public function getFileList() {
        $dir = $this->sqlFolder;
        $files2 = scandir($dir, 1);
        $files2 = array_diff($files2, array('..', '.'));

        foreach ($files2 as $value) {
            $item['filename'] = $value;
            $content = file_get_contents($this->sqlFolder . "/$value");
            $item['content'] = $content;
            $item['date'] = date('d/m/Y', filemtime($this->sqlFolder . '/' . $value));
            $ret[] = $item;
        }

        return $ret;
    }

    public function save() {

        $my_file = $this->sqlFolder . '/' . $this->filename ;
        $handle = fopen($my_file, 'w') or die('Cannot open file:  ' . $my_file);
        $data = $this->content;
        fwrite($handle, $data);
        fclose($handle);
    }

    public function read($id) {
        $fileLst = $this->getFileList();
        $this->filename = $fileLst[$id]['filename'];
        $this->content = $fileLst[$id]['content'];
        $this->date = $fileLst[$id]['date'];
    }

    public function setDataFromRequest($post) {
        $this->filename = $post->filename;
        $this->content = $post->content;
    }

}

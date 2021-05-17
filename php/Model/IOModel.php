<?php

/**
 * Class IOModel
 *
 * Methods and function to interact with IO
 */
class IOModel
{
    private $root;

    /**
     * IOModel constructor.
    */
    public function __construct(){
        $this->root = $_SERVER['DOCUMENT_ROOT'];
    }

    /**
     * Saves a picture given as base-64 string to a file in a directory that is created with the lobby an round index
     *
     * @param string $pictureBase64 Content of file to be saved as base-64 string
     * @param string $lobbyIndex Index of Lobby  (used as directory-name)
     * @param string $roundIndex Index of round (used as directory-name)
     * @param string $pictureIndex Index of Picture (used as filename)
     */
    public function savePicture(String $pictureBase64, String $lobbyIndex, String $roundIndex, String $pictureIndex){
        $path = $this->createRoundFolder($lobbyIndex, $roundIndex);
        $path .= "/" . $pictureIndex . ".txt";

        $myfile = fopen($path, "w") or die("Unable to open file!");
        fclose($myfile);
        if(is_file($path) or is_writable($path)) {
            file_put_contents($path, $pictureBase64);
        }
        echo "PATH". $path;
        return $path;
    }

    /**
     * Returns the path to a picture given by its id
     * @param int $pictureIndex Index of picture
     * @return string Path of picture
     */
    public function returnPathOfPictureIndex(String $pictureIndex){
        $filename = $pictureIndex . ".txt";
        return $this->rsearch($this->root, $filename);
    }

    //*************************************************************************
    // Private Methods
    //*************************************************************************
    private function createLobbyFolder(String $lobbyIndex){
        $path = $this->root;
        $path .= "/sketches/" . $lobbyIndex;
        if(!file_exists($path)){
            mkdir($path, 0777, true);
        }

        return $path;
    }

    private function createRoundFolder(String $lobbyIndex, String $roundIndex){
        $path =  $this->createLobbyFolder($lobbyIndex);
        $path .= "/" . $roundIndex;

        if(!file_exists($path)){
            mkdir($path , 0777, true);
        }

        return $path;
    }

    private function rsearch($folder, $pattern){
        $iti = new RecursiveDirectoryIterator($folder);
        foreach (new RecursiveIteratorIterator($iti) as $file) {
            if (strpos($file, $pattern) !== false) {
                return $file;
            }
        }
        return false;
    }
}
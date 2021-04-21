<?php


class IOModel
{
    private $root;

    public function __construct(String $root){
        $this->root = $root;
    }

    /**
     * saves a picture given as base-64 string to a file in a directory that is created with the lobby an round index
     *
     * @param String $pictureBase64 Content of file to be saved as base-64 string
     * @param String $lobbyIndex Index of Lobby  (used as directory-name)
     * @param String $roundIndex Index of round (used as directory-name)
     * @param String $pictureIndex Index of Picture (used as filename)
     */
    public function savePicture(String $pictureBase64, String $lobbyIndex, String $roundIndex, String $pictureIndex){
        $path = createRoundFolder($lobbyIndex, $roundIndex);
        $path .= "/" . $pictureIndex . ".png";
        if(is_file($path) or is_writable($path)) {
            file_put_contents($path, base64_decode($pictureBase64));
        }
        return $path;
    }

    /**
     * Returns the path to a picture given by its id
     * @param $pictureIndex Index of picture
     * @return string Path of picture
     */
    public function returnPathOfPictureIndex(String $pictureIndex){
        $filename = $pictureIndex . ".txt";
        return rsearch($this->root, filename);
    }

    /**
     * Delete lobby with a given index
     * @param $lobbyIndex lobby to index
     */
    private function deleteLobby(String $lobbyIndex){
        $path = $this->rsearch($this->root, $lobbyIndex);
        if(file_exists($path)){
            rmdir($this->rsearch($this->root, $lobbyIndex));
        }
    }

    private function createLobbyFolder(String $lobbyIndex){
        $path = $this->root;
        $path .= "/" . $lobbyIndex;

        if(!file_exists($path)){
            mkdir($path, 0777, true);
        }

        return $path;
    }

    private function createRoundFolder(String $lobbyIndex, String $roundIndex){
        $path =  $this->createRoundFolder($lobbyIndex);
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
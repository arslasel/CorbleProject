<?php


class IOModel
{
    private $root;

    public function __construct(String $root){
        $this->root = $root;
    }

    /**
     * saves a picture given as base-64 string to a file in a directory that is created on the lobby an round index
     *
     * @param String $pictureBase64 Content of file to be saved as base-64 string
     * @param String $lobbyIndex Index of Lobby  (used as directory-name)
     * @param String $roundIndex Index of round (used as directory-name)
     * @param String $pictureIndex Index of Picture (used as filename)
     */
    public function savePicture(String $pictureBase64, String $lobbyIndex, String $roundIndex, String $pictureIndex){
        $path = createRoundFolder($lobbyIndex, $roundIndex);
        $path .= "/" . $pictureIndex . ".txt";
        $fd = dio_open($path, O_CREAT);
        dio_write($fd, $pictureBase64);
        dio_close( $fd);
    }

    /**
     * Creates a folder for a given lobby
     *
     * @param String $lobbyIndex String with index of lobby (unique)
     * @return String Returns string of created folder
     */
    public function createLobbyFolder(String $lobbyIndex){
        $path = $this->root;
        $path .= "/" . $lobbyIndex;

        if(!file_exists($path)){
            mkdir($path, 0777, true);
         }

        return $path;
    }

    /**
     * Creates a folder for a given round and lobby -> allways checks if lobby
     * is existing and creates a foler if not
     *
     * @param String $lobbyIndex String with index of rond (unique)
     * @return String Returns string of created folder
     */
    public function createRoundFolder(String $lobbyIndex, String $roundIndex){
        $path =  $this->createRoundFolder($lobbyIndex);
        $path .= "/" . $roundIndex;

        if(!file_exists($path)){
         mkdir($path , 0777, true);
        }

        return $path;
    }

    /**
     * Returns the path to a picture given by its id
     * @param $pictureIndex
     * @return string
     */
    public function returnPathOfPictureIndex($pictureIndex){
        $filename = $pictureIndex . ".txt";
        $path = "";

        // TODO search file;
        return $path;
    }
}
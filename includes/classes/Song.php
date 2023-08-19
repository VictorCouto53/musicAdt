<?php
    class Song {
    	private $con;
    	private $id;
        private $sqlData;
    	private $title;
    	private $artistId;
        private $albumId;
    	private $genre;
    	private $path;
        private $duration;

    	public function __construct($con, $id) {
    		$this->con = $con;
            $this->id = $id;

            $query = mysqli_query($this->con, "SELECT * FROM songs WHERE id='$this->id'");

            $this->sqlData = mysqli_fetch_array($query);
            $this->title = $this->sqlData['title'];
            $this->artistId = $this->sqlData['artist'];
            $this->albumId = $this->sqlData['album'];
            $this->genre = $this->sqlData['genre'];
            $this->duration = $this->sqlData['duration'];
            $this->path = $this->sqlData['path'];
        }

        public function getSqlData() {
            return $this->sqlData;
        }

        public function getTitle() {
            return $this->title;
        }

        public function getId() {
            return $this->id;
        }

        public function getArtist() {
            return new Artist($this->con, $this->artistId);
        }

        public function getAlbum() {
            return new Album($this->con, $this->albumId);
        }

        public function getGenre() {
            return $this->genre;
        }

        public function getDuration() {
            return $this->duration;
        }

        public function getPath() {
            return $this->path;
        }     
    }
?>
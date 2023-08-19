----------  phpMyAdmin SQL Simple  ----------
-- http://www.phpmyadmin.net
-- Host: localhost


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";




---------------------  Database: `musicAdt`  ---------------------



---- Creating table structure for albums ----

CREATE TABLE IF NOT EXISTS `albums` (
`id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `artist` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `artworkPath` varchar(500) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;


----  Data for inserting into table `albums` ----

INSERT INTO `albums` (`id`, `title`, `artist`, `genre`, `artworkPath`) VALUES
(1, 'Last Roman', 2, 1, 'resources/images/artwork/belisarius.jpg'),
(2, 'Meditations', 1, 2, 'resources/images/artwork/marcus-aurelius.jpg'),
(3, 'First Emperor', 3, 5, 'resources/images/artwork/caesar-augustus.jpg'),
(4, 'The Richest Man', 4, 3, 'resources/images/artwork/crassus.jpg'),
(5, 'The Conqueror', 5, 6, 'resources/images/artwork/julius-caesar.jpg');


---- Creating table structure for artists ----


CREATE TABLE IF NOT EXISTS `artists` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;


----  Data for inserting into table `artists` ----

INSERT INTO `artists` (`id`, `name`) VALUES
(1, 'Marcus Aurelius'),
(2, 'Flavius Belisarius'),
(3, 'Augustus Caesar'),
(4, 'Marcus Licinius Crassus'),
(5, 'Gaius Julius Caesar');


---- Creating table structure for genres ----

CREATE TABLE IF NOT EXISTS `genres` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;


----  Data for inserting into table `genres` ----

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Classic'),
(2, 'Instrumental'),
(3, 'Pop'),
(4, 'Rock'),
(5, 'Rap'),
(6, 'Acoustic'),
(7, 'R & B');

---- Creating table structure for playlists ----

CREATE TABLE IF NOT EXISTS `playlist` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `owner` varchar(50) NOT NULL,
  `dateCreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


---- Creating table structure for songs of playlists ----

CREATE TABLE IF NOT EXISTS `songsplaylist` (
`id` int(11) NOT NULL,
  `songId` int(11) NOT NULL,
  `playlistId` int(11) NOT NULL,
  `playlistOrder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


---- Creating table structure for songs ----

CREATE TABLE IF NOT EXISTS `songs` (
`id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `artist` int(11) NOT NULL,
  `album` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `duration` varchar(8) NOT NULL,
  `path` varchar(500) NOT NULL,
  `albumOrder` int(11) NOT NULL,
  `plays` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;


----  Data for inserting into table `songs` ----

INSERT INTO `Songs` (`id`, `title`, `artist`, `album`, `genre`, `duration`, `path`, `albumOrder`, `plays`) VALUES
(1, 'Piano Moment', 2, 1, 1, '1:50', 'resources/musics/pianomomment.mp3', 1, 0),
(2, 'All That', 1, 2, 2, '2:26', 'resources/musics/allthat.mp3', 1, 0),
(3, 'Clap And Yell', 1, 2, 2, '2:56', 'resources/musics/clapandyell.mp3', 2, 0),
(4, 'Creative Minds', 2, 1, 1, '2:27', 'resources/musics/creativeminds.mp3', 2, 0),
(5, 'Dreams', 2, 1, 1, '3:30', 'resources/musics/dreams.mp3', 3, 0),
(6, 'Elevate', 3, 3, 5, '3:29', 'resources/musics/elevate.mp3', 1, 0),
(7, 'Evolution', 3, 3, 4, '2:45', 'resources/musics/evolution.mp3', 2, 0),
(8, 'Fun Day', 4, 4, 3, '3:13', 'resources/musics/funday.mp3', 1, 0),
(9, 'Funky Suspense', 4, 4, 3, '4:16', 'resources/musics/funkysuspense.mp3', 2, 0),
(10, 'Happy Rock', 5, 5, 6, '1:45', 'resources/musics/happyrock.mp3', 1, 0),
(11, 'Hey', 5, 5, 6, '2:52', 'resources/musics/hey.mp3', 2, 0),
(12, 'Inspire', 1, 2, 2, '3:33', 'resources/musics/inspire.mp3', 3, 0),
(13, 'Jazzy Frenchy', 3, 3, 5, '1:44', 'resources/musics/jazzyfrenchy.mp3', 3, 0),
(14, 'Memories', 4, 4, 3, '3:50', 'resources/musics/memories.mp3', 3, 0),
(15, 'Once Again', 5, 5, 7, '3:51', 'resources/musics/onceagain.mp3', 3, 0),
(16, 'Photo Album', 2, 1, 1, '3:16', 'resources/musics/photoalbum.mp3', 4, 0),
(17, 'Ukelele', 2, 1, 1, '2:26', 'resources/musics/ukelele.mp3', 5, 0);


---- Creating table structure for users ----

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  `signUpDate` datetime NOT NULL,
  `picProfile` varchar(500) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;


---- Id for all tables ----

ALTER TABLE `albums`
 ADD PRIMARY KEY (`id`);

--

ALTER TABLE `artists`
 ADD PRIMARY KEY (`id`);

-- 

ALTER TABLE `genres`
 ADD PRIMARY KEY (`id`);

-- 

ALTER TABLE `playlists`
 ADD PRIMARY KEY (`id`);

--

ALTER TABLE `songsplaylist`
 ADD PRIMARY KEY (`id`);

--

ALTER TABLE `songs`
 ADD PRIMARY KEY (`id`);

-- 

ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--

---- automatic increment for all tables ----

ALTER TABLE `albums`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;

ALTER TABLE `artists`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;

ALTER TABLE `genres`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;

ALTER TABLE `playlists`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `songsplaylist`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `songs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;

ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;

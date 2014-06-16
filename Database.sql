-- phpMyAdmin SQL Dump
-- version 4.2.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 16, 2014 at 04:20 PM
-- Server version: 10.0.11-MariaDB-1~sid-log
-- PHP Version: 5.5.11-3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `scene`
--

-- --------------------------------------------------------

--
-- Table structure for table `scene_comments`
--

CREATE TABLE IF NOT EXISTS `scene_comments` (
`comment_id` bigint(31) unsigned NOT NULL COMMENT 'Designates the id number of the comment.',
  `scene_id` bigint(31) unsigned NOT NULL COMMENT 'Designates to what scene the comment belongs',
  `pose_id` int(11) DEFAULT NULL,
  `player_id` bigint(31) unsigned NOT NULL COMMENT 'Designates who added the comment.',
  `Comment` text NOT NULL COMMENT 'The comment!'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `scene_config`
--

CREATE TABLE IF NOT EXISTS `scene_config` (
`scene_id` bigint(31) unsigned NOT NULL COMMENT 'Identifies the scene',
  `timeout_skip` double unsigned NOT NULL DEFAULT '2400' COMMENT 'How long, in seconds, until we set a player as skip',
  `timeout_pause` double unsigned NOT NULL DEFAULT '7200' COMMENT 'How long, in seconds, until we set a scene as paused',
  `timeout_unfinished` double unsigned NOT NULL DEFAULT '604800' COMMENT 'How long, in seconds, until we set a scene as unfinished',
  `scene_lock` varchar(255) NOT NULL DEFAULT '#TRUE' COMMENT 'Identifies the lock of the scene, a player needs to pass',
  `scene_title` varchar(40) DEFAULT NULL COMMENT 'Identifies the title of the scene',
  `scene_desc` longtext COMMENT 'Describes the scene in plain ascii',
  `scene_players` text NOT NULL COMMENT 'Lists the players in the scene at the time of an update',
  `scene_state` enum('0','1','2','3') NOT NULL DEFAULT '0' COMMENT 'Identifies the state of the scene. Finished (3), Unfinished (2), Paused (1) or Active (0)',
  `scene_ordered` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Do we keep track of the playerorder? We do anyhow, but do we actually warn people that they posed out of turn?',
  `scene_announce` varchar(255) NOT NULL COMMENT 'Announce upon creation?',
  `scene_private` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Is the scene private?',
  `spam_timer` smallint(2) NOT NULL DEFAULT '4' COMMENT 'Keeps an integer value, for how many poses there can be per 10 seconds.',
  `scene_owner` varchar(255) NOT NULL COMMENT 'Identifies the scene''s owner.',
  `scene_ctime` datetime NOT NULL COMMENT 'Shows when the scene was created.',
  `scene_etime` datetime DEFAULT NULL COMMENT 'Indicates when the scene ended, or was set unfinished.'
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `scene_journals`
--

CREATE TABLE IF NOT EXISTS `scene_journals` (
`journal_id` bigint(31) unsigned NOT NULL COMMENT 'Identifies the journal.',
  `player_id` bigint(31) NOT NULL COMMENT 'Identifies the poser_id who created the journal.',
  `journal_time` datetime NOT NULL COMMENT 'Identifies when when the journal was created.',
  `journal_title` varchar(255) NOT NULL COMMENT 'Identifies the title of the journal.',
  `journal_lock` varchar(255) NOT NULL DEFAULT '#FALSE' COMMENT 'Identifies who can see the journal. ''#FALSE'' for ''only self''.',
  `journal_text` longtext NOT NULL COMMENT 'Contains the contents of the journal.',
  `journal_html` longtext NOT NULL COMMENT 'Contains the contents of the journal, in HTML format..'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `scene_players`
--

CREATE TABLE IF NOT EXISTS `scene_players` (
`player_id` bigint(31) NOT NULL COMMENT 'Identifies the player',
  `player_objid` varchar(255) NOT NULL COMMENT 'Identifies the player''s object identity. DBREF:CSECS',
  `player_initname` varchar(255) NOT NULL DEFAULT 'Unset' COMMENT 'Designates the player''s initial name.',
  `activescene_id` bigint(31) DEFAULT NULL COMMENT 'Identifies the scene the poser is active in. Empty if N/A.',
  `scenecreate_announce` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Do they announce a scene starting by default if creating one?',
  `bitlevel` enum('1','2','3') NOT NULL DEFAULT '1' COMMENT 'Designates the level of the player. ''1'' for player, ''2'' for ''staff'' and ''3'' for''headwizard''.',
  `warnings` set('newposewhileaway','scenefinish','outofroompose','inroompose') NOT NULL DEFAULT 'newposewhileaway,scenefinish,outofroompose,inroompose' COMMENT 'Indicates what warnings a user wants to listen to.',
  `spammer` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Indicates whether or not someone is a spammer - thus locked from SceneSys.',
  `setup` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Claims whether or not a player is setup for the system.'
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `scene_posers`
--

CREATE TABLE IF NOT EXISTS `scene_posers` (
  `poser_playerid` varchar(255) NOT NULL DEFAULT '#-1' COMMENT 'Identifies the poser in the scene',
  `poser_away` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Identifies the poser as away',
  `poser_skip` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Identifies the poser as to ''be skipped''',
  `scene_id` bigint(20) unsigned NOT NULL COMMENT 'Identifies the scene the poser is in',
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Keeps track of when the player was last active in this scene.'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `scene_poses`
--

CREATE TABLE IF NOT EXISTS `scene_poses` (
`pose_id` bigint(31) unsigned NOT NULL COMMENT 'Identifies the pose uniquely',
  `order_id` bigint(31) unsigned DEFAULT '0' COMMENT 'Identifies the pose per scene',
  `scene_id` bigint(31) unsigned NOT NULL COMMENT 'Identifies the scene the pose belongs to',
  `owner_id` bigint(31) unsigned NOT NULL COMMENT 'Identifies the owner of the scene, at the time of the pose',
  `poser_id` bigint(31) unsigned NOT NULL DEFAULT '1' COMMENT 'Identifies the poser of the pose',
  `poser_name` varchar(255) NOT NULL COMMENT 'Name of character at the time of the pose',
  `pose_time` datetime NOT NULL COMMENT 'The time at which the pose/message was created or last edited ',
  `pose_penn` longtext COMMENT 'The body of the pose in ansi text',
  `pose_room` varchar(255) DEFAULT NULL COMMENT 'The database reference number of the room in which the pose was made',
  `pose_room_name` varchar(255) DEFAULT NULL COMMENT 'The name of the room the pose was made in at the time of the pose',
  `ignore` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Do we ignore this pose?',
  `sysevent` varchar(255) DEFAULT NULL COMMENT 'Was there a system event? SYSEVENT | English representation.',
  `comment` text COMMENT 'Comment on a pose or system event.'
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=141 ;

-- --------------------------------------------------------

--
-- Table structure for table `scene_relationships`
--

CREATE TABLE IF NOT EXISTS `scene_relationships` (
`GLOBID` int(11) NOT NULL COMMENT 'The global id',
  `RECURSEID` int(11) DEFAULT NULL COMMENT 'Points at a global id - forming a relationship with it of being its child.',
  `PLOTNAME` varchar(255) DEFAULT NULL COMMENT 'Name of the plot',
  `PLOTDESC` varchar(255) DEFAULT NULL COMMENT 'Description of the plot',
  `SCENEID` int(11) DEFAULT NULL COMMENT 'The ID of the scene, if applicable.'
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `scene_schedule`
--

CREATE TABLE IF NOT EXISTS `scene_schedule` (
`id` int(10) unsigned NOT NULL COMMENT 'Schedule ID',
  `time` datetime NOT NULL COMMENT 'Time and Day',
  `title` varchar(255) NOT NULL COMMENT 'Scene Title',
  `description` text NOT NULL COMMENT 'Scene Description',
  `room` varchar(255) DEFAULT NULL COMMENT 'Room the scene is scheduled to take place in - optional.',
  `player_id` bigint(31) NOT NULL COMMENT 'Who scheduled the scene',
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `scene_tags`
--

CREATE TABLE IF NOT EXISTS `scene_tags` (
`tag_id` bigint(31) unsigned NOT NULL COMMENT 'Identifies the tag',
  `poser_id` bigint(31) unsigned NOT NULL DEFAULT '1' COMMENT 'Identifies the creator of the tag',
  `scene_id` bigint(31) unsigned NOT NULL COMMENT 'Identifies the scene the tag applies to',
  `tag` varchar(255) NOT NULL COMMENT 'Identifies the tag by a name'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `scene_comments`
--
ALTER TABLE `scene_comments`
 ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `scene_config`
--
ALTER TABLE `scene_config`
 ADD PRIMARY KEY (`scene_id`), ADD KEY `timeout_away` (`timeout_skip`,`timeout_pause`,`timeout_unfinished`), ADD KEY `scene_state` (`scene_state`), ADD FULLTEXT KEY `scene_title` (`scene_title`,`scene_desc`,`scene_players`);

--
-- Indexes for table `scene_journals`
--
ALTER TABLE `scene_journals`
 ADD PRIMARY KEY (`journal_id`);

--
-- Indexes for table `scene_players`
--
ALTER TABLE `scene_players`
 ADD PRIMARY KEY (`player_id`), ADD UNIQUE KEY `player_objid_2` (`player_objid`);

--
-- Indexes for table `scene_posers`
--
ALTER TABLE `scene_posers`
 ADD PRIMARY KEY (`poser_playerid`,`scene_id`);

--
-- Indexes for table `scene_poses`
--
ALTER TABLE `scene_poses`
 ADD PRIMARY KEY (`pose_id`), ADD UNIQUE KEY `COMPOSITE` (`scene_id`,`order_id`), ADD FULLTEXT KEY `pose_penn` (`pose_penn`);

--
-- Indexes for table `scene_relationships`
--
ALTER TABLE `scene_relationships`
 ADD PRIMARY KEY (`GLOBID`);

--
-- Indexes for table `scene_schedule`
--
ALTER TABLE `scene_schedule`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scene_tags`
--
ALTER TABLE `scene_tags`
 ADD PRIMARY KEY (`tag_id`), ADD UNIQUE KEY `TAG_TO_SCENE` (`tag_id`,`scene_id`), ADD FULLTEXT KEY `tag` (`tag`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `scene_comments`
--
ALTER TABLE `scene_comments`
MODIFY `comment_id` bigint(31) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Designates the id number of the comment.';
--
-- AUTO_INCREMENT for table `scene_config`
--
ALTER TABLE `scene_config`
MODIFY `scene_id` bigint(31) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifies the scene',AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `scene_journals`
--
ALTER TABLE `scene_journals`
MODIFY `journal_id` bigint(31) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifies the journal.';
--
-- AUTO_INCREMENT for table `scene_players`
--
ALTER TABLE `scene_players`
MODIFY `player_id` bigint(31) NOT NULL AUTO_INCREMENT COMMENT 'Identifies the player',AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `scene_poses`
--
ALTER TABLE `scene_poses`
MODIFY `pose_id` bigint(31) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifies the pose uniquely',AUTO_INCREMENT=141;
--
-- AUTO_INCREMENT for table `scene_relationships`
--
ALTER TABLE `scene_relationships`
MODIFY `GLOBID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'The global id',AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `scene_schedule`
--
ALTER TABLE `scene_schedule`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Schedule ID',AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `scene_tags`
--
ALTER TABLE `scene_tags`
MODIFY `tag_id` bigint(31) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifies the tag';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


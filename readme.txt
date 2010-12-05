PyroCMS Magazine Issue Management Module
------------------------------------------


Use following SQL to create Issues table

/*----------sql begin--------------*/
--
-- Table structure for table `issues`
--

CREATE TABLE IF NOT EXISTS `issues` (
  `issue_id` int(11) NOT NULL AUTO_INCREMENT,
  `total_issue_no` int(11) NOT NULL,
  `year_count` int(11) DEFAULT NULL,
  `year_issue_no` int(11) DEFAULT NULL,
  `nepali_year` int(11) NOT NULL,
  `nepali_month` varchar(30) NOT NULL,
  `status` tinyint(11) NOT NULL,
  `is_current` tinyint(4) NOT NULL,
  PRIMARY KEY (`issue_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

/*----------sql end--------------*/

- the category module code is used as base code this module.
- module is a simple CRUD interface in admin for Issue related CRUD operation. 
- this module adds Issue Number & Nepali Year, Month to the database 

Cheers!
Blog: http://bit.ly/bhu1st
Twitter: @bhu1st 
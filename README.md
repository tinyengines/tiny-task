# tiny-task
A very simple issue tracking system.  Used in house by sambwa.com.  Excellent for remote teams with less than a half dozen users.  Simply send an email message to a designated email address and the subject line becomes the task, the sender the task owner and the task can be administered from a web interface for the entire team to see.  See a live <a href="http://bugs.sambwa.com/">demo here</a>.

<img src="https://raw.githubusercontent.com/tinyengines/tiny-task/master/assets/screenshot.jpg" alt="Tiny Task Screenshot" />

## Installation
### Clone the Repository (or simply download and install in your web application directory)
    $ git clone https://github.com/tinyengines/tiny-task.git

### Create Email Address on your Server to Execute PHP Script
Begin by creating an email address that can execute a script.  If your server implements CPanel, you will need to select <i>Email Forwarders</i>.  Within Email Forwarders, enter the new email address to forward (ex. bugs@sambwa.com) and then select <i>Advanced Options</i>.  You will utilize the <i>Pipe to Program</i> text field.  Enter the location of the <b>tinytask_mailhandler.php</b> script on your server.  Some servers require this location be prefixed with the unix pipe symbol (|), while others require the php command to proceed the location (ex. php tinytask_mailhandler.php). We strongly recommend that you ask your server administrator to assist in setting up this forwarder (we did!).  You may need to change the permissions for tinytask_mailhandler.php to allow the forwarder to execute the script.  Again ask your server administrator. Ok, the hard part is over!

### Create Database Table
Our email handling script won't function at this stage as we have no database table to store recieved information.  Let's create the appropriate MySQL database & database table on our web server. 

Using PHPMyAdmin or your favourite method, create a new database or add the following table to an existing database:

```SQL
CREATE TABLE `Tasks` (
  `ID` int(100) NOT NULL,
  `Label` text NOT NULL,
  `From_User` text NOT NULL,
  `From_Email` text NOT NULL,
  `Completed` tinyint(1) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

### Configure config.php file

Change the values in the config.php file to match your needs :

```php
$tinytask_email = "example@example.com";                        //email that runs script
$tinytask_title = "Tiny Task - Simple Task Management";             //Site title
$tinytask_introduction = "Welcome to Tiny Tasks' Task Management page";	//introduction on main task page

// Database configuration
$tinytask_db_user = "example_user";             //database account user name
$tinytask_db_pass = "example_pass";	        //password for database user account
$tinytask_db_name = "example_database_name";    //the name of the database

// Convert timestamps on task list to correct time zone
// (see - https://en.wikipedia.org/wiki/List_of_tz_database_time_zones)
$tinytask_timezone_server = "US/Pacific";	//Region the Tiny Task is hosed
$tinytask_timezone_users = "Asia/Kuala_Lumpur";	//Region the Tiny Task is used in
```

### Congratulations
Tiny Task is now ready to use.  Browse to the location of the <i>index.php</i> file using your prefered browser and share this location with your team. Begin creating tasks and checking them off at your desktop, on your phone, and anywhere you have access to email or a web browser! Let us know how your team enjoys Tiny Task [admin@sambwa.com]

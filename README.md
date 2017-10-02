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

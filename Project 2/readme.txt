
Correlation of Services and Network Communications


Folder Contents                       Content Description
---------------                       -------------------
split.php					=>	This file contains the php script to find the path of db.conf.
backend_devices_osr.pl				=>	This file contains the backend script of the devices part.
backend_servers_osr.pl                          =>       This file contains the backend script of the servers part.
backend.sh					=> 	This file is used to run the perl scripts backend_devicees_osr.pl and backend_servers_osr.pl for every one minute
index.php					=> 	This webpage displays the number of options to enter into the next pages and also includes adding and deleting  
                                                       of the servers and devices 								


readme.txt					=>  	This file contains how to execute the total total what to be inserted 						            	where and so on the total working of the tool.
add_plot.php					=> 	This  script displays options to select devices, interfaces and servers to be plotted.


Prerequisites
-------------
php 5.0.x or greater versions
perl
snmp
snmpd
apache server
php5-snmp
php5-mysql
libapache2-mod-php5
mysql-server
DBI
DBD::mysql
Net::SNMP
LWP::UserAgent

Prerequisites Installation
--------------------------
(Install the listed prerequisites to avoid any prerequisite errors)
(Installation steps for snmp and snmpd packages are described in Net::SNMP installation steps)
php  	     					-> sudo apt-get install php5
php5-snmp					-> sudo apt-get install php5-snmp
php5-mysql					-> sudo apt-get install php5-mysql
php5-apache2					-> sudo apt-get install php5-apache2
perl 	     					-> sudo apt-get install perl
apach server 					-> sudo apt-get install apache2
libapache2-mod-php5 				-> sudo apt-get install libapache2-mod-php5
mysql-server 					-> sudo apt-get install mysql-server
DBI  	     					-> sudo apt-get install libdbi-perl
DBD::mysql    	1. Install libmysqlclient-dev package by typing the following command in the terminal: 					->	 sudo apt-get install libmysqlclient-dev 
								2. Download the DBD-mysql-4.028.tar.gz file from the link:
 								http://search.cpan.org/~capttofu/DBD-mysql-4.028/lib/DBD/mysql.pm
								3. Extract the DBD-mysql-4.028.tar.gz file to a desired directory.
								4. Open terminal and change to that directory (cd <path to directory>/DBD-mysql-4.028).
								5. Type the following commands one after the other:
												$ perl Makefile.PL
												$ make
												# make install  (Here # indicates you need to execute that command as root).


Net::SNMP     	1. Install snmp package by typing the following command in the terminal:
										->	 sudo apt-get install snmp
		2. Install snmpd package by typing the following command in the terminal: 										->	sudo apt-get install snmpd
								3. Install libperl-dev package by typing the following command in the terminal: 
										->	sudo apt-get install libperl-dev
								4. Install libnet-snmp-perl package by typing the following command in the terminal:
										->  sudo apt-get install libnet-snmp-perl
								5. Download the net-snmp-5.x.x.x.tar.gz file from the link: http://www.net-snmp.org/download.html (click on any of the source to download the file).
								6. Extract the net-snmp-5.x.x.x.tar.gz file to a desired directory.
								7. Open terminal and change to that directory (cd <path to directory>/net-			snmp-5.x.x.x).
								8. Type the following commands one after the other:
												$ ./configure
  											$ make
  											# make install  (Here # indicates you need to execute that command as root).

LWP:UserAgent
			 1.Install the LWP:UserAgent by the following way
				-> perl -MCPAN -e 'install Bundle::LWP'
(3) The apache web server should be configured to run webpages from the folder the tool is placed in.

(3) All read and write permission are to be enabled to all the folders places inside the directory.

NETWORK LEVEL configurations:
-------------------------------
(4) To retrieve data through HTTP at the network level, the server-status file of Apache web server is parsed depending on the permissions . Following are the changes enabled:
Go to '/etc/apache2/sites-available/default' file and add the following lines:

			<Location /server-status>
			    SetHandler server-status
			    Order deny,allow
			    Allow from all
					Deny from none
			</Location>
 
For pasing the server status of specific servers, include "Allow from <IP address>" instead of the above line. By default, all are enabled in using the following command.

(5) In order to install LWP Agent following is the package required:
	sudo apt-get install liblwp-useragent-determined-perl	

APPLICATION LEVEL configurations:
----------------------------------
(6) Following packages are necessary to retrieve data through SNMP:

	=> sudo apt-get install libpango1.0-dev
	=> sudo apt-get install libxml2-dev
	=> sudo apt-get install libsnmp-perl
	=> sudo apt-get install libsnmp-dev
	=> sudo apt-get install libnet-snmp-perl
	=> sudo apt-get install rrdtool
	=> perl -MCPAN -e 'install Net::SNMP'
	=> perl -MCPAN -e 'install Net::SNMP::Interfaces'
	=> sudo apt-get install php5-rrd
	=> sudo apt-get install librrds-perl
	=> sudo apt-get install libdbi-perl

Following is the procedure to observe and correlate the performance metrics of devices and servers:
---------------------------------------------------------------------------------------------------

(7) The user accesses the webpage by entering the path to "/et2536-veti15/assignment2"
Enable permissions to the the entire folder and also its sub-files: sudo chmod -R 777 /et2536-veti15/assignment2.

(8) On the webpage, the necessary device credentials should be entered and added.
		i)Enter ip address under ip,port number under port,community name under community and then hit 				the Add button.
		ii)List of interfaces of that device will be displayed and please neglect the last "INTERFACE:" as the partition is done that way and it is just printed. Enter the interfaces to be probed under interfaces seperated by a comma .Example: 1,2,3.......
		iii)For probing multiple devices, the ip,port,community for a device need to be filled followed by the interfaces and then the other devices details need to be entered.On hitting the submit button at the bottom of the page you can view the device details on the next page.

(9) Similar procedure for adding server credentials is also to be followed.
		i) Enter the IP address under IP, HTTP port number under HTTP, hit the ADD button.Finally hit the submit button. 

(10) After entering all the necessary credentials for probing the submit button is hit which will redirect you to the next page.

(11) After entering the next page you will see the database table, followed by enter id and enter interfaces to be probed among the list of interfaces that are being probed,enter the required 	id and interfaces of that device for which u want to see the rrd graph and press add.If another devices is to be monitored then again enter the id and interfaces.If different interfaces 		 are to be monitored then enter the device id and enter the interface numbers you see in the databade.

(12) Below that you will be seeing the metrics like InOctets,Outoctes,AggregatedIn,AggregatedOut,All. Select whichever metric you want to see in the graphs

(12) If graphs are'nt required for a paticular device then delete the device by entering the id of 			 the device in the field provided below and press the delete button

(13) Then at the bottom of the page you can see the server database followed by the enter id for which you want to view the graph.Enter the required id for and the select the metrics which are to be displayed for these devices and then press the add button.

(14) If graphs are'nt required for a paticular server then delete the server details by entering the id of the server in the field provided below the graphs of server database and press the delete button

(15) Once you finished entering the details before pressing the "SUBMIT" button open the terminal and 		 run the backend.sh program present in the assignment2 folder and then press the submit button.After pressing the SUBMIT button you will find the graphs there if you entered only the 		 network device details you will find only those graphs. If you add the server details then you will find the server graphs also.

(16) To keep it tidy all the rrd files will be stored in the respective folder in the rrd folder  present in the assignment2 folder once a device is deleted these rrd files also get deletd 

(17) Wait for 5 to 10 minutes so the the rrd gets updated with values for the lines on the graphs to be 		 displayed. 

(18) For deleting any device press the delete button which is present to the side of the device.


DISCLAIMER
----------
Current input is expected at each field in the form to make sure the program runs properly. 
 



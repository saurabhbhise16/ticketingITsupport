PHP & MySQL-based Support Ticketing App________________________________________
1. Introduction
In any organization, IT support is an essential service that ensures the proper functioning of technological resources, such as computers, printers, and software. To efficiently manage and address issues reported by end users, an IT Support Ticketing System provides a streamlined way for users to submit requests, and for IT teams to monitor and resolve those requests.
This report details the development of a simple IT Support Ticketing System built using PHP and XAMPP (a local development environment for PHP), along with a MySQL database for managing tickets.
________________________________________
2. Objectives
The primary objectives of the IT Support Ticketing System are:
1.	To provide an easy interface for users to report IT-related issues such as OS support, printer issues, and network problems.
2.	To offer a management interface for administrators to view and manage tickets.
3.	To allow IT staff to track the status of each ticket and change its state (e.g., from "Open" to "In Progress" and eventually "Closed").
________________________________________
3. System Features
The ticketing system includes the following key features:
3.1 Ticket Submission
•	Users can submit a support request by filling out a simple form. They provide their name, email address, type of issue (OS support, printer support, etc.), and a description of the issue.
3.2 Admin Dashboard
•	Admins can view all submitted tickets in a dashboard that displays ticket details, including the ticket ID, name, email, issue type, status, and the creation time of the ticket.
•	Admins can view individual tickets by clicking on a "View" link next to each ticket in the dashboard.
3.3 Ticket Status Management
•	Admins can change the status of a ticket to one of the following:
o	Open: The ticket has been submitted but not yet addressed.
o	In Progress: IT support is actively working on the issue.
o	Closed: The issue has been resolved, and the ticket is considered complete.
3.4 Database Management
•	The system uses a MySQL database to store all ticket-related data. The database contains a table with fields such as id, name, email, issue_type, message, status, and created_at.
________________________________________
4. Technologies Used
4.1 PHP
•	The primary programming language used for developing the web-based application.
•	PHP is used to handle form submissions, database interactions, and to render dynamic pages based on user input and ticket data.
4.2 MySQL
•	A relational database management system used to store and manage ticket data.
•	The database contains a table called tickets to store the user's name, email, issue type, description, and the status of the ticket.
4.3 XAMPP
•	XAMPP provides a complete local server environment, including Apache (web server), MySQL (database server), and PHP.
•	XAMPP was used to run the PHP application and store the data in the MySQL database.
4.4 HTML & CSS
•	Used for designing the frontend of the ticket submission form and admin dashboard.
•	Basic styling was applied to create a user-friendly experience.
________________________________________
5. Database Design
The database consists of a single table called tickets, with the following structure:
Column Name	Data Type	Description
id	INT AUTO_INCREMENT	Primary Key, Unique Ticket ID
name	VARCHAR(100)	Name of the user submitting the ticket
email	VARCHAR(100)	Email address of the user
issue_type	VARCHAR(50)	Type of issue (e.g., OS, Printer, Network)
message	TEXT	Detailed description of the issue
status	VARCHAR(20)	Current status of the ticket (Open, In Progress, Closed)
created_at	TIMESTAMP	Timestamp when the ticket was created
________________________________________
6. System Architecture
The system follows a basic client-server architecture:
•	Frontend (Client): A simple web interface for submitting tickets (index.php) and viewing them (admin.php, view_ticket.php).
•	Backend (Server): PHP scripts interact with the MySQL database to store and retrieve ticket data. PHP processes form submissions, updates the database, and displays ticket information to users and admins.
________________________________________
7. User Flow
1.	Ticket Submission:
o	A user accesses the index.php page and fills out the support ticket form.
o	Upon submission, the ticket is inserted into the MySQL database with a status of "Open".
2.	Admin Dashboard:
o	Admins can log into the admin.php page to view a list of all submitted tickets.
o	Each ticket shows essential information like the issue type, status, and timestamp.
3.	View & Update Ticket:
o	Admins can click on any ticket's "View" link to access the view_ticket.php page, which shows the full ticket details.
o	The admin can then change the ticket status from "Open" to "In Progress" or "Closed", depending on the progress of the resolution.
________________________________________
8. Security Considerations
The system, in its basic form, does not include advanced security measures like authentication, input sanitization, and user validation. For a production environment, the following measures should be implemented:
1.	User Authentication: Only authorized admins should have access to the admin dashboard.
2.	Input Validation & Sanitization: Protect the system from SQL injection and XSS (Cross-Site Scripting) attacks by sanitizing user inputs.
3.	Error Handling: Implement proper error handling to avoid exposing sensitive information (e.g., database details).
________________________________________
9. Conclusion
The IT Support Ticketing System developed in PHP using XAMPP provides an efficient way for users to report issues and for IT staff to manage and resolve those issues. While the system is basic, it serves as a foundational framework that can be expanded with additional features such as authentication, detailed reporting, and notifications for ticket updates.
This simple ticketing system can be customized and scaled for organizations of various sizes, improving communication between users and IT support teams, and ultimately helping to streamline the process of managing technical issues.


 
Figure 1: Admin view
 
Figure 2: Ticket Detail
 
Figure 3: Ticket Submission
 
Figure 4: Ticket Status Update

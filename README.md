# PHP & MySQL-based Support Ticketing App

## 1. Introduction

In any organization, IT support is an essential service that ensures the proper functioning of technological resources such as computers, printers, and software. To efficiently manage and address issues reported by end users, an IT Support Ticketing System provides a streamlined way for users to submit requests and for IT teams to monitor and resolve them.

This project outlines the development of a simple IT Support Ticketing System built using PHP, XAMPP, and MySQL.

---

## 2. Objectives

The primary objectives of the IT Support Ticketing System are:

1. Provide an easy interface for users to report IT-related issues such as OS support, printer issues, and network problems.  
2. Offer a management interface for administrators to view and manage tickets.  
3. Allow IT staff to track the status of each ticket and change its state (e.g., from "Open" to "In Progress" to "Closed").

---

## 3. System Features

### 3.1 Ticket Submission
- Users can submit a support request by filling out a simple form.
- Fields: name, email, issue type (OS support, printer support, etc.), and a message.

### 3.2 Admin Dashboard
- Admins can view all submitted tickets in a dashboard.
- Displays: ticket ID, name, email, issue type, status, and creation timestamp.
- Includes a "View" link to inspect ticket details.

### 3.3 Ticket Status Management
- Admins can change the ticket status to:
  - **Open**: Ticket is newly submitted.
  - **In Progress**: Issue is being worked on.
  - **Closed**: Issue resolved.

### 3.4 Database Management
- Ticket data is stored in a MySQL database.
- Table fields: `id`, `name`, `email`, `issue_type`, `message`, `status`, `created_at`.

---

## 4. Technologies Used

### 4.1 PHP
- Server-side scripting for form handling, database operations, and rendering dynamic content.

### 4.2 MySQL
- Database used to store ticket data.

### 4.3 XAMPP
- Local server stack including Apache, MySQL, and PHP used for development and testing.

### 4.4 HTML & CSS
- Frontend structure and basic styling for user and admin interfaces.

---

## 5. Database Design

Table: `tickets`

| Column Name | Data Type        | Description                              |
|-------------|------------------|------------------------------------------|
| id          | INT AUTO_INCREMENT | Primary Key, Unique Ticket ID           |
| name        | VARCHAR(100)     | Name of the user submitting the ticket   |
| email       | VARCHAR(100)     | Email address of the user                |
| issue_type  | VARCHAR(50)      | Type of issue (e.g., OS, Printer, Network) |
| message     | TEXT             | Description of the issue                 |
| status      | VARCHAR(20)      | Ticket status: Open, In Progress, Closed |
| created_at  | TIMESTAMP        | Timestamp when the ticket was created    |

---

## 6. System Architecture

The system follows a basic **client-server architecture**:

- **Frontend (Client)**:  
  - `index.php`: User-facing form for ticket submission.  
  - `admin.php`, `view_ticket.php`: Admin-facing interfaces for managing tickets.

- **Backend (Server)**:  
  - PHP scripts handle form submissions, interact with MySQL, and render content dynamically.

---

## 7. User Flow

### 1. Ticket Submission
- User accesses `index.php`, fills the form, and submits it.
- A new ticket is stored in the database with status "Open".

### 2. Admin Dashboard
- Admin accesses `admin.php` to view all submitted tickets.

### 3. View & Update Ticket
- Admin clicks "View" to open `view_ticket.php`, showing full ticket details.
- Admin can update ticket status.

---

## 8. Security Considerations

This basic system does not yet include advanced security. In a production-ready version, implement the following:

1. **Authentication**: Restrict admin access using login credentials.
2. **Input Validation & Sanitization**: Prevent SQL injection and XSS attacks.
3. **Error Handling**: Avoid exposing sensitive data (e.g., SQL errors) to users.

---

## 9. Conclusion

The IT Support Ticketing System built with PHP and MySQL offers a straightforward platform for managing technical support requests. While currently basic, it can be extended with features like user authentication, automated email notifications, and analytics.

The system improves communication between users and IT teams, enabling faster response and resolution to technical issues.

---

## Screenshots

> *(Replace with actual image links or add screenshots in a `/screenshots` folder and use Markdown image syntax)*

- **Figure 1:** Admin View  
- **Figure 2:** Ticket Detail  
- **Figure 3:** Ticket Submission Form  
- **Figure 4:** Ticket Status Update Interface  

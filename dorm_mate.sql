CREATE TABLE admins (
    admin_id INT(6) AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY(admin_id)
) ENGINE=InnoDB; 


CREATE TABLE students (
    student_id INT(6) AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY(student_id)
) ENGINE=InnoDB;


CREATE TABLE login (
    email VARCHAR(255) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'student') NOT NULL,
    FOREIGN KEY (email) REFERENCES admins(email) ON DELETE CASCADE,
    FOREIGN KEY (email) REFERENCES students(email) ON DELETE CASCADE
) ENGINE=InnoDB;






CREATE TABLE admins (
    admin_id INT(6) AUTO_INCREMENT,
    admin_name VARCHAR(255),
    email VARCHAR(255) UNIQUE NOT NULL,
    admin_password VARCHAR(255) NOT NULL,
    PRIMARY KEY(admin_id)
) ENGINE=InnoDB;

CREATE TABLE student (
    student_id INT(6) AUTO_INCREMENT,
    student_name VARCHAR(255),
    email VARCHAR(255) UNIQUE NOT NULL,
    student_password VARCHAR(255) NOT NULL,
    PRIMARY KEY(student_id)
) ENGINE=InnoDB;


CREATE TABLE permit (
    permit_id INT(6) AUTO_INCREMENT,
    student_id INT(6) NOT NULL,
    permit_type ENUM('late-night-permit', 'overnight-permit', 'weekend-permit') NOT NULL,
    permit_status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    date_filed TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(permit_id),
    FOREIGN KEY (student_id) REFERENCES student(student_id) ON DELETE CASCADE
) ENGINE=InnoDB;




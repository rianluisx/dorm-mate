CREATE TABLE admin (
    admin_id INT(6) AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    admin_password VARCHAR(255) NOT NULL,
    PRIMARY KEY(admin_id)
) ENGINE=InnoDB;

CREATE TABLE student (
    student_id INT(6) AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    student_password VARCHAR(255) NOT NULL,
    PRIMARY KEY(student_id)
) ENGINE=InnoDB;

CREATE TABLE permit (
    permit_id INT(6) AUTO_INCREMENT,
    student_id INT(6) NOT NULL,
    permit_type ENUM('late-night-permit', 'overnight-permit', 'weekend-permit') NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    applied_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    admin_id INT(6),
    PRIMARY KEY(permit_id),
    FOREIGN KEY (student_id) REFERENCES student(student_id) ON DELETE CASCADE,
    FOREIGN KEY (admin_id) REFERENCES admin(admin_id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE login (
    email VARCHAR(255) PRIMARY KEY,
    user_password VARCHAR(255) NOT NULL,
    user_role ENUM('admin', 'student') NOT NULL,
    FOREIGN KEY (email) REFERENCES admin(email) ON DELETE CASCADE,
    FOREIGN KEY (email) REFERENCES student(email) ON DELETE CASCADE
) ENGINE=InnoDB;

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
    room_number VARCHAR(10) NOT NULL,
    time_out VARCHAR(50) NOT NULL,
    expected_date DATE NOT NULL,
    destination VARCHAR(255) NOT NULL,
    purpose VARCHAR(255) NOT NULL,
    in_care_of VARCHAR(255) NOT NULL,
    emergency_contact VARCHAR(255) NOT NULL,
    date_filed TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(permit_id),
    FOREIGN KEY (student_id) REFERENCES student(student_id) ON DELETE CASCADE
) ENGINE=InnoDB;




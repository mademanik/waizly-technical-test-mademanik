-- waizly_db.employees definition

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `salary` float NOT NULL,
  `department` varchar(255) NOT NULL,
  `joined_date` date NOT NULL,
  PRIMARY KEY (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `sales_data` (
  `sales_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `sales` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
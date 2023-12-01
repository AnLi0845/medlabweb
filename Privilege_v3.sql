/*Objectives
Implement role-based access control (RBAC) to manage access to various parts
of the database based on job roles within the lab accaording to the Least Privilege Principle

SELECT, UPDATE, INSERT, DELETE, WITH GRANT OPTION

SHOW GRANT;
SHOW GRANT FOR 'USER'@'hostname';
*/

-- Create Roles
CREATE ROLE 'LabTechnician', 'Secretary';

-- Lab staff: Perform medical sampling and tests, report results
GRANT USAGE,SELECT, UPDATE, INSERT ON MedLab.Tests_Catalog TO 'LabTechnician';
GRANT USAGE,SELECT, UPDATE, INSERT ON MedLab.Results TO 'LabTechnician';
GRANT USAGE,SELECT ON MedLab.Staff TO 'LabTechnician';

-- Secretaries: Manage appointments for sampling from patients, make patients pay, print out result reports
GRANT USAGE,SELECT, UPDATE, INSERT, DELETE ON MedLab.Appointments TO 'Secretary';
GRANT USAGE,SELECT, UPDATE, INSERT ON MedLab.Billing TO 'Secretary';
GRANT USAGE,SELECT ON MedLab.Results TO 'Secretary';
GRANT USAGE,SELECT, UPDATE, INSERT ON MedLab.Orders TO 'Secretary';
GRANT USAGE,SELECT, UPDATE ON  MedLab.Staff TO 'Secretary';
GRANT USAGE,SELECT ON MedLab.Patients TO 'Secretary';

/*
Patients: Access their test orders and results, as well as their bills
GRANT USAGE,SELECT ON MedLab.Orders TO 'Patients';
GRANT USAGE,SELECT ON MedLab.Results TO 'Patients';
GRANT USAGE,SELECT ON MedLab.Billing TO 'Patients';

Remark: Since the patents should not be able to access the database directly,
they only can access their test order, results and their bills through the frontend webpage,
therefore, no need to set role for the patients.

*/



-- Create User
CREATE USER 'johndoe'@'%' IDENTIFIED BY 'John123';
CREATE USER 'janesmith'@'%' IDENTIFIED BY 'Jane123';
CREATE USER 'michaelbrown'@'%' IDENTIFIED BY 'Michael123';
CREATE USER 'sarahdavis'@'%' IDENTIFIED BY 'Sarah123';


-- assign role 
GRANT 'LabTechnician' TO 'johndoe'@'%';
GRANT 'Secretary' TO 'janesmith'@'%';
GRANT 'LabTechnician' TO 'michaelbrown'@'%';
GRANT 'Secretary' TO 'sarahdavis'@'%';



-- SET ROLE command should run at user, not root account
-- Need to set role before use
-- SET ROLE 'LabTechnician'; -- This command need to login to the user first
-- SET ROLE 'Secretary'; -- This command need to login to the user first




-- Inserting into Roles Table
INSERT INTO Roles (Role_Name) VALUES
('LabTechnician'),
('Secretary');

-- mysql> select * from  Roles; to check 


-- Creating encryt method and hash function to insert Staff data
DELIMITER //

CREATE PROCEDURE AddStaff(
    IN s_First_Name VARCHAR(255), 
    IN s_Last_Name VARCHAR(255), 
    IN s_Email VARCHAR(255), 
    IN s_Phone_Number VARCHAR(20), 
    IN s_Address VARCHAR(255), 
    IN s_Role_ID INT,
    IN s_Username VARCHAR(255), 
    IN s_Plain_Password VARCHAR(255)
)
BEGIN
    SET @salt = TO_BASE64(RANDOM_BYTES(16));
    SET @hashed_password = SHA2(CONCAT(s_Plain_Password, @salt), 256);
    SET block_encryption_mode = 'aes-256-cbc';
    SET @init_vector = RANDOM_BYTES(16);
    SET @key_str = "My secret passphrase";
    SET @encrypted_email = AES_ENCRYPT(s_Email, @key_str, @init_vector,"hkdf");
    SET @encrypted_phone_number = AES_ENCRYPT(s_Phone_Number, @key_str, @init_vector, "hkdf");
    SET @encrypted_address = AES_ENCRYPT(s_Address, @key_str, @init_vector, "hkdf");

    INSERT INTO Staff (
        First_Name, 
        Last_Name, 
        Email, 
        Phone_Number, 
        Address,
        Role_ID,
        Username, 
        Password, 
        Salt,
        IV
    ) VALUES (
        s_First_Name, 
        s_Last_Name, 
        @encrypted_email, 
        @encrypted_phone_number, 
        @encrypted_address,
        s_Role_ID,
        s_Username, 
        @hashed_password, 
        @salt,
        @init_vector
    );
END //

DELIMITER ;

-- insert the value with
CALL AddStaff('John', 'Doe', 'john.doe@example.com', '555-1111', '123 Park Ave, Cityville', 1, 'johndoe', 'John123');
CALL AddStaff('Jane', 'Smith', 'jane.smith@example.com', '555-2222', '456 Oak St, Townsville', 2, 'janesmith', 'Jane123');
CALL AddStaff('Michael', 'Brown', 'michael.b@example.com', '555-4444', '321 Maple Dr, Hamletville', 1, 'michaelbrown', 'Michael123');
CALL AddStaff('Sarah', 'Davis', 'sarah.d@example.com', '555-5555', '654 Elm St, Burgville', 2, 'sarahdavis', 'Sarah123');

 
DELIMITER //

CREATE PROCEDURE AddPatient(
    IN p_First_Name VARCHAR(255), 
    IN p_Last_Name VARCHAR(255), 
    IN p_Date_of_Birth DATE, 
    IN p_Email VARCHAR(255), 
    IN p_Phone_Number VARCHAR(20), 
    IN p_Address VARCHAR(255), 
    IN p_Username VARCHAR(255), 
    IN p_Plain_Password VARCHAR(255)
)
BEGIN
    SET @salt = TO_BASE64(RANDOM_BYTES(16)); --  create salt 
    SET @hashed_password = SHA2(CONCAT(p_Plain_Password, @salt), 256); -- hash the password with salt
    SET block_encryption_mode = 'aes-256-cbc';  -- enable AES-256-cbc mode
    SET @init_vector = RANDOM_BYTES(16);  -- generate IV
    SET @key_str = "My super secret passphrase";   -- create the key string for encrypt or decrypt
    SET @encrypted_email = AES_ENCRYPT(p_Email, @key_str, @init_vector,"hkdf");  -- encrypt the Email
    SET @encrypted_phone_number = AES_ENCRYPT(p_Phone_Number, @key_str, @init_vector, "hkdf"); -- encrypt PhoneNumber
    SET @encrypted_address = AES_ENCRYPT(p_Address, @key_str, @init_vector, "hkdf"); -- encrypt address

    INSERT INTO Patients (
        First_Name, 
        Last_Name, 
        Date_of_Birth, 
        Email, 
        Phone_Number, 
        Address,
        Username, 
        Password, 
        Salt, -- If not exit, alter table and add the salt column with varbinary(64)
        IV   -- If not exit, alter table and add the IV column with varbinary(16)
    ) VALUES (
        p_First_Name, 
        p_Last_Name, 
        p_Date_of_Birth,
        @encrypted_email, 
        @encrypted_phone_number, 
        @encrypted_address,
        p_Username, 
        @hashed_password, 
        @salt,
        @init_vector
    );
END //

DELIMITER ;

-- insert the value with
CALL AddPatient('Alex', 'Johnson', '1985-04-23', 'alex.johnson@example.com', '555-0101', '123 Maple Street, Anytown, AT 12345', 'alexj85', 'Alex123');
CALL AddPatient('Maria', 'Garcia', '1992-08-15', 'maria.garcia@example.com', '555-0202', '456 Oak Avenue, Sometown, ST 67890', 'mariag92', 'Maria123');
CALL AddPatient('David', 'Smith', '1977-11-30', 'david.smith@example.com', '555-0303', '789 Birch Road, Difftown, DT 54321', 'davesmith77', 'David123');

-- Assuming the Insurance details are linked with Patients
-- Inserting into Insurance Table
-- Note: The Insurance_ID and Patient_ID will be auto-generated from the inserts above. Ensure the Patient_IDs match here.
INSERT INTO Insurance (Patient_ID, Provider, Plan) VALUES
(1, 'HealthCare Inc.', 'Full Plan'),
(2, 'BestLife', 'Basic Plan'),
(3, 'QuickHealth', 'Extended Plan');

-- Inserting into Tests_Catalog Table
INSERT INTO Tests_Catalog (Test_Code, Test_Name, Description, Cost) VALUES
('BLOOD01', 'Complete Blood Count', 'A comprehensive test that counts red cells, white cells, and platelets.', 50.00),
('LIPID02', 'Lipid Profile', 'Measures lipids including cholesterol and triglycerides.', 35.00),
('GLUCO03', 'Blood Glucose Test', 'Measures the amount of glucose in the blood.', 20.00),
('THYR04', 'Thyroid Function Test', 'Evaluates thyroid hormone levels.', 40.00),
('METAB05', 'Basic Metabolic Panel', 'Measures glucose, calcium, and electrolytes.', 30.00);



-- Continue with the Orders, Appointments, Results, and Billing tables in a similar fashion
-- Ensure the foreign keys match the respective primary keys of the records in the Patients, Tests_Catalog, and Staff tables

-- Inserting into Orders Table
INSERT INTO Orders (Patient_ID, Test_Code, Ordering_Physician, Order_Date, Status) VALUES
(1, 'BLOOD01', 2, '2023-10-01', 'Pending'),
(2, 'LIPID02', 2, '2023-10-03', 'Completed'),
(3, 'GLUCO03', 4, '2023-10-05', 'In Progress'),
(1, 'THYR04', 4, '2023-10-07', 'Cancelled'),
(2, 'METAB05', 2, '2023-10-09', 'Pending');

-- Inserting into Appointments Table
-- Make sure the Order_ID matches the IDs from the Orders table.
INSERT INTO Appointments (Patient_ID, Order_ID, Date, Time) VALUES
(1, 1, '2023-11-15', '09:00:00'),
(2, 2, '2023-10-16', '10:30:00'),
(3, 3, '2023-10-17', '08:45:00'),
(2, 5, '2023-11-18', '14:00:00');

-- Inserting into Results Table
-- Ensure the Order_ID matches the Orders table.
INSERT INTO Results (Order_ID, Report_URL, Interpretation, Reporting_Pathologist) VALUES
(1, 'http://www.medtestlab.com/reports/4001', 'Normal Blood Cell Count', 3),
(2, 'http://www.medtestlab.com/reports/4002', 'Elevated Cholesterol Levels', 3),
(3, 'http://www.medtestlab.com/reports/4003', 'Blood Glucose Levels Normal', 3),
(5, 'http://www.medtestlab.com/reports/4005', 'Electrolyte Balance Normal', 3);

-- Inserting into Billing Table
-- The Order_ID should be consistent with the Orders table.
INSERT INTO Billing (Order_ID, Billed_Amount, Payment_Status, Insurance_Claim_Status) VALUES
(1, 50.00, 'Paid', 'Claim Submitted'),
(2, 35.00, 'Unpaid', 'Claim Approved'),
(3, 20.00, 'Paid', 'Claim Denied'),
(4, 40.00, 'Cancelled', 'N/A'),
(5, 30.00, 'Payment Pending', 'Claim Processing');






/*
DELIMITER //

CREATE PROCEDURE AddStaff(
    IN s_First_Name VARCHAR(255), 
    IN s_Last_Name VARCHAR(255), 
    IN s_Email VARCHAR(255), 
    IN s_Phone_Number VARCHAR(20), 
    IN s_Address VARCHAR(255), 
    IN s_Role_ID INT,
    IN s_Username VARCHAR(255), 
    IN s_Plain_Password VARCHAR(255)
)
BEGIN
    SET @salt = TO_BASE64(RANDOM_BYTES(16));
    SET @hashed_password = SHA2(CONCAT(s_Plain_Password, @salt), 256);
    SET block_encryption_mode = 'aes-256-cbc';
    SET @init_vector = RANDOM_BYTES(16);
    SET @key_str = "My secret passphrase";
    SET @encrypted_email = AES_ENCRYPT(s_Email, @key_str, @init_vector,"hkdf");
    SET @encrypted_phone_number = AES_ENCRYPT(s_Phone_Number, @key_str, @init_vector, "hkdf");
    SET @encrypted_address = AES_ENCRYPT(s_Address, @key_str, @init_vector, "hkdf");

    INSERT INTO Staff (
        First_Name, 
        Last_Name, 
        Email, 
        Phone_Number, 
        Address,
        Role_ID,
        Username, 
        Password, 
        Salt,
        IV
    ) VALUES (
        s_First_Name, 
        s_Last_Name, 
        @encrypted_email, 
        @encrypted_phone_number, 
        @encrypted_address,
        s_Role_ID,
        s_Username, 
        @hashed_password, 
        @salt,
        @init_vector
    );
END //

DELIMITER ;

*/

/* Decrypt Staff information

DELIMITER //

CREATE PROCEDURE DecryptStaffInfo(
    IN s_Username VARCHAR(255)
)
BEGIN
    DECLARE enc_email VARBINARY(255);
    DECLARE enc_phone VARBINARY(255);
    DECLARE enc_address VARBINARY(255);
    DECLARE staff_iv VARBINARY(16);

    SELECT Email, Phone_Number, Address, IV INTO enc_email, enc_phone, enc_address, staff_iv
    FROM Staff
    WHERE Username = s_Username;

    SET block_encryption_mode = 'aes-256-cbc';
    SET @s_key_str = "My secret passphrase";
    SET @decrypted_email = AES_DECRYPT(enc_email, @s_key_str, staff_iv, "hkdf");
    SET @decrypted_phone_number = AES_DECRYPT(enc_phone, @s_key_str, staff_iv, "hkdf");
    SET @decrypted_address = AES_DECRYPT(enc_address, @s_key_str, staff_iv, "hkdf");

    SELECT @decrypted_email AS Email, @decrypted_phone_number AS Phone_Number, @decrypted_address AS Address;
END //

DELIMITER ;


CALL DecryptStaffInfo('johndoe');

*/




























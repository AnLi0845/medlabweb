-- Create Database named MedLab
Create Database MedLab;
use medlab;
-- Creating Roles Table
CREATE TABLE Roles (
    Role_ID INT AUTO_INCREMENT PRIMARY KEY,
    Role_Name VARCHAR(255) UNIQUE
);

-- Creating Staff Table
CREATE TABLE Staff (
    Staff_ID INT AUTO_INCREMENT PRIMARY KEY,
    First_Name VARCHAR(255),
    Last_Name VARCHAR(255),
    Email VARBINARY(255), -- Apply encryption in application logic
    Phone_Number VARBINARY(20), -- Apply encryption in application logic
    Address VARBINARY(255), -- Apply encryption in application logic
    Role_ID INT,
    Username VARCHAR(255) UNIQUE,
    Password VARCHAR(255), -- Store hashed passwords
    Salt VARBINARY(64),
    IV VARBINARY(16),
    FOREIGN KEY (Role_ID) REFERENCES Roles(Role_ID)
);

CREATE TABLE Patients (
    Patient_ID INT AUTO_INCREMENT PRIMARY KEY,
    First_Name VARCHAR(255),
    Last_Name VARCHAR(255),
    Date_of_Birth DATE,
    Email VARBINARY(255), -- Apply encryption in application logic
    Phone_Number VARBINARY(20), -- Apply encryption in application logic
    Address VARBINARY(255), -- Apply encryption in application logic
    Username VARCHAR(255) UNIQUE,
    Password VARCHAR(255), -- Store hashed passwords
    Salt VARBINARY(64),
    IV VARBINARY(16)
);

-- Creating Insurance Table
CREATE TABLE Insurance (
    Insurance_ID INT AUTO_INCREMENT PRIMARY KEY,
    Patient_ID INT,
    Provider VARCHAR(255),
    Plan VARCHAR(255),
    FOREIGN KEY (Patient_ID) REFERENCES Patients(Patient_ID)
);

-- Creating Tests Catalog Table
CREATE TABLE Tests_Catalog (
    Test_Code VARCHAR(50) PRIMARY KEY,
    Test_Name VARCHAR(255),
    Description TEXT,
    Cost DECIMAL(10, 2)
);

-- Creating Orders Table
CREATE TABLE Orders (
    Order_ID INT AUTO_INCREMENT PRIMARY KEY,
    Patient_ID INT,
    Test_Code VARCHAR(50),
    Ordering_Physician INT,
    Order_Date DATE,
    Status ENUM('Pending', 'Completed', 'In Progress', 'Cancelled'),
    FOREIGN KEY (Patient_ID) REFERENCES Patients(Patient_ID),
    FOREIGN KEY (Test_Code) REFERENCES Tests_Catalog(Test_Code),
    FOREIGN KEY (Ordering_Physician) REFERENCES Staff(Staff_ID)
);

-- Creating Appointments Table
CREATE TABLE Appointments (
    Appointment_ID INT AUTO_INCREMENT PRIMARY KEY,
    Patient_ID INT,
    Order_ID INT,
    Date DATE,
    Time TIME,
    FOREIGN KEY (Patient_ID) REFERENCES Patients(Patient_ID),
    FOREIGN KEY (Order_ID) REFERENCES Orders(Order_ID)
);

-- Creating Results Table
CREATE TABLE Results (
    Result_ID INT AUTO_INCREMENT PRIMARY KEY,
    Order_ID INT,
    Report_URL VARCHAR(255), -- Apply encryption if necessary
    Interpretation TEXT,
    Reporting_Pathologist INT,
    FOREIGN KEY (Order_ID) REFERENCES Orders(Order_ID),
    FOREIGN KEY (Reporting_Pathologist) REFERENCES Staff(Staff_ID)
);

-- Creating Billing Table
CREATE TABLE Billing (
    Billing_ID INT AUTO_INCREMENT PRIMARY KEY,
    Order_ID INT,
    Billed_Amount DECIMAL(10, 2),
    Payment_Status ENUM('Paid', 'Unpaid', 'Payment Pending', 'Cancelled'),
    Insurance_Claim_Status ENUM('Claim Submitted', 'Claim Approved', 'Claim Denied', 'Claim Processing', 'N/A'),
    Date_Created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Date_Updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Order_ID) REFERENCES Orders(Order_ID)
);

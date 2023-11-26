-- Decrypt Staff information
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
   
    SELECT 
    CONVERT(AES_DECRYPT(enc_email, @s_key_str, staff_iv, "hkdf") USING utf8mb4) AS Email, 
    CONVERT(AES_DECRYPT(enc_phone, @s_key_str, staff_iv, "hkdf") USING utf8mb4) AS Phone_Number, 
    CONVERT(AES_DECRYPT(enc_address, @s_key_str, staff_iv, "hkdf") USING utf8mb4) AS Address;
END //

DELIMITER ;

-- Call the function

CALL DecryptStaffInfo('johndoe');


------------------------------------------------------------------------------------------------


-- Decrypt Patients Information

DELIMITER //

CREATE PROCEDURE DecryptPatientInfo(
    IN p_Username VARCHAR(255)
)
BEGIN
    DECLARE enc_email VARBINARY(255);
    DECLARE enc_phone VARBINARY(255);
    DECLARE enc_address VARBINARY(255);
    DECLARE patient_iv VARBINARY(16);

    SELECT Email, Phone_Number, Address, IV INTO enc_email, enc_phone, enc_address, patient_iv
    FROM Patients
    WHERE Username = p_Username;

    SET block_encryption_mode = 'aes-256-cbc';
    SET @p_key_str = "My super secret passphrase";
   
    SELECT 
    CONVERT(AES_DECRYPT(enc_email, @p_key_str, patient_iv, "hkdf") USING utf8mb4) AS Email, 
    CONVERT(AES_DECRYPT(enc_phone, @p_key_str, patient_iv, "hkdf") USING utf8mb4) AS Phone_Number, 
    CONVERT(AES_DECRYPT(enc_address, @p_key_str, patient_iv, "hkdf") USING utf8mb4) AS Address;
END //

DELIMITER ;

-- Call the function

CALL DecryptPatientInfo('alexj85');


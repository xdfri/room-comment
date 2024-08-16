--buatlah database dengan nama 'komen'
--lalu masukan perintah beriku

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- tambahan 

ALTER TABLE comments
ADD COLUMN parent_id INT NULL DEFAULT NULL;


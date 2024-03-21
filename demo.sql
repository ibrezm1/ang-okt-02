USE test;
-- Table Definition
CREATE TABLE demo_guests (
    guestId INT AUTO_INCREMENT PRIMARY KEY,
    guestName VARCHAR(100) NOT NULL,
    checkInDate DATE NOT NULL,
    guestEmail VARCHAR(100) NOT NULL,
    roomNumber INT NOT NULL
);

-- Sample Data
INSERT INTO demo_guests (guestName, checkInDate, guestEmail, roomNumber) VALUES
('John Doe', '2024-03-18', 'john@example.com', 101),
('Jane Smith', '2024-03-19', 'jane@example.com', 102),
('Alice Johnson', '2024-03-20', 'alice@example.com', 103);
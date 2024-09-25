INSERT INTO vouchers (name, description, value, start_date, end_date, is_active, created_at, updated_at)
VALUES
    ('Summer Sale', 'Get 20% off on all summer items', 20.00, '2024-06-01', '2024-08-31', true, NOW(), NOW()),
    ('New Customer Discount', 'Welcome offer: $10 off your first purchase', 10.00, '2024-09-01', '2024-12-31', true, NOW(), NOW());

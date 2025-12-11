
```php
INSERT IGNORE INTO category (category_name) VALUES ('Phones');
INSERT IGNORE INTO class (class_name) VALUES ('Smartphones');

INSERT INTO products (name, product_description, category_id, class_id, price, stock, img_url, ROM, RAM) VALUES
(
    'M-phone 17', '48MP Main | Ultra Wide<br>Super Retina XDR Display, A16 Bionic Chip, 20h Video Playback', (SELECT id FROM category WHERE category_name = 'Phones'),
    (SELECT id FROM class WHERE class_name = 'Smartphones'), 79999.00, 50, '../assets/Phones/iphone17.png',128, 8         
),

(
    'M-phone 17 Air',
    '48MP Main | Ultra Wide<br>Lightweight Design, M15 Bionic Chip, 18h Video Playback',
    (SELECT id FROM category WHERE category_name = 'Phones'),(SELECT id FROM class WHERE class_name = 'Smartphones'),69999.00,  
    75,  '../assets/Phones/Iphone17_air.png', 256, 8         
),

(
    'M-phone 17 Pro','48MP Main | Ultra Wide | Telephoto<br>ProMotion Technology, A17 Pro Chip, 29h Video Playback',
    (SELECT id FROM category WHERE category_name = 'Phones'), (SELECT id FROM class WHERE class_name = 'Smartphones'),
    99999.00, 30, '../assets/Phones/Iphone17Pro.png',512, 12        
);


```


--use this to reset the auto id
```php
ALTER TABLE class AUTO_INCREMENT = 0;
ALTER TABLE products AUTO_INCREMENT = 0;
ALTER TABLE category AUTO_INCREMENT = 0;
```
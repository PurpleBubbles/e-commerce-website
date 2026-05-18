CREATE TABLE USERS (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(50) NOT NULL ,
    password_hashed VARCHAR(255) NOT NULL,
    user_email VARCHAR(50) UNIQUE NOT NULL,
    user_phone VARCHAR(20) NOT NULL,
    location VARCHAR(100),
    is_buyer boolean DEFAULT TRUE,
    is_seller boolean DEFAULT FALSE,
    is_admin boolean DEFAULT FALSE,
    date_created DATE NOT NULL DEFAULT (NOW()),
    last_updated DATE NOT NULL DEFAULT (NOW())
);
/*
Vehicles =1
Property =2
Clothing =3
Electronics=4
Books =5
Furniture =6
Decorations =7
0ther =8
*/
CREATE TABLE CATEGORIES (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(50) NOT NULL,
    description VARCHAR(100),
    sort_order INT
);

CREATE TABLE LOCATIONS (
    location_id INT AUTO_INCREMENT PRIMARY KEY,
    province VARCHAR(50) not null,
    postal_code INT UNIQUE NOT NULL,
    city VARCHAR(50)
);

CREATE TABLE PRODUCTS (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(50) NOT NULL,
    description VARCHAR(300),
    price DECIMAL(10,2) NOT NULL,
    /*
    1= means product is new
    2= means product is used
    3= means product is refurbished
    4= means product is damaged
    5= means product is broken
    */
    product_condition INT NOT NULL ,
    /*
    1= means product is available
    0= means product is not available
    */
    status INT NOT NULL default 1,
    category_id INT,
    FOREIGN KEY (category_id) REFERENCES CATEGORIES(category_id),
    posted_at DATE NOT NULL DEFAULT (NOW()) ,
    updated_at DATE NOT NULL DEFAULT (NOW()),
    user_id INT,
    category_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES USERS(user_id),
    location_id INT,
    FOREIGN KEY (location_id) REFERENCES LOCATIONS(location_id),
    FOREIGN KEY (category_id) REFERENCES CATEGORIES(category_id)
);

CREATE TABLE PRODUCT_IMAGES(
    image_id INT AUTO_INCREMENT PRIMARY KEY,
    image LONGBLOB NOT NULL,
    display_order INT NOT NULL,
    product_id INT,
    FOREIGN KEY (product_id) REFERENCES PRODUCTS(product_id)
);

CREATE TABLE PAYMENTS (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    amount DECIMAL(10,2) NOT NULL ,
    method VARCHAR(50),
    status INT,
    paid_at DATE
);

CREATE TABLE SAVES (
    save_id INT AUTO_INCREMENT PRIMARY KEY,
    save_date DATE NOT NULL,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES USERS(user_id),
    product_id INT,
    FOREIGN KEY (product_id) REFERENCES  PRODUCTS(product_id)
);

CREATE TABLE OFFERS (
    offer_id INT AUTO_INCREMENT PRIMARY KEY,
    offer_amount DECIMAL(10,2) NOT NULL,
    offer_status INT NOT NULL,
    created_at DATE NOT NULL,
    responded_at DATE,
    product_id INT,
    FOREIGN KEY (product_id) REFERENCES PRODUCTS(product_id),
    buyer_user_id INT,
    FOREIGN KEY (buyer_user_id) REFERENCES USERS(user_id),
    seller_user_id INT,
    FOREIGN KEY (seller_user_id) REFERENCES USERS(user_id)
);

CREATE TABLE REFUNDS (
    refund_id INT AUTO_INCREMENT PRIMARY KEY,
    refund_reason VARCHAR(200) NOT NULL,
    refund_request_status INT NOT NULL,
    is_refunded BOOLEAN DEFAULT FALSE,
    buyer_user_id INT,
    FOREIGN KEY (buyer_user_id) REFERENCES USERS(user_id),
    admin_user_id INT,
    FOREIGN KEY (admin_user_id) REFERENCES USERS(user_id)
);

CREATE TABLE TRANSACTIONS (
    transaction_id INT AUTO_INCREMENT PRIMARY KEY,
    created_at DATE NOT NULL,
    completed_at DATE,
    refund_id INT,
    FOREIGN KEY (refund_id) REFERENCES REFUNDS(refund_id),
    offer_id INT,
    FOREIGN KEY (offer_id) REFERENCES OFFERS(offer_id)
);

CREATE TABLE REVIEWS (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    rating INT NOT NULL,
    review_content VARCHAR(200) NOT NULL,
    created_at DATE NOT NULL,
    last_edit DATE NOT NULL,
    buyer_user_id INT,
    FOREIGN KEY (buyer_user_id) REFERENCES USERS(user_id)
);

CREATE TABLE REPORTS (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    report_reason VARCHAR(200) NOT NULL,
    reported_at DATE NOT NULL default (NOW()),
    completed_at DATE,
    resolution VARCHAR(200),
    product_id INT,
    FOREIGN KEY (product_id) REFERENCES PRODUCTS(product_id),
    admin_user_id INT,
    FOREIGN KEY (admin_user_id) REFERENCES USERS(user_id)
);

CREATE TABLE CONVERSATIONS (
  conversation_id INT AUTO_INCREMENT PRIMARY KEY,
  started_at DATE NOT NULL,
  buyer_user_id INT,
  FOREIGN KEY (buyer_user_id) REFERENCES USERS(user_id),
  seller_user_id INT,
  FOREIGN KEY (seller_user_id) REFERENCES  USERS(user_id)
);

CREATE TABLE MESSAGES(
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    message_content VARCHAR(200) NOT NULL,
    sent_by INT NOT NULL,
    sent_at DATE NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    conversation_id INT,
    FOREIGN KEY (conversation_id) REFERENCES CONVERSATIONS(conversation_id)
);

CREATE TABLE SELLER_INFO(
    seller_id VARCHAR(10) PRIMARY KEY,
    house_address VARCHAR(200) NOT NULL,
    bank_name VARCHAR(50) NOT NULL,
    bank_account INT NOT NULL,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES USERS(user_id)
);

CREATE TABLE BOUGHT(
    bought_id INT AUTO_INCREMENT PRIMARY KEY,
    bought_at DATE NOT NULL DEFAULT (NOW()),
    product_id INT,
    FOREIGN KEY (product_id) REFERENCES PRODUCTS(product_id),
    buyer_user_id INT,
    FOREIGN KEY (buyer_user_id) REFERENCES USERS(user_id)
);


# Freelance Marketplace (Fiverr-lite)

College-friendly PHP/MySQL implementation of a freelance marketplace.

## Features
- Buyer and seller registration/login
- Seller gig posting
- Gig browsing and details
- Order creation
- Simulated escrow payment: held -> delivered -> released
- Buyer/seller chat using database polling on page refresh
- Ratings and reviews
- Dashboard and earnings

## Requirements
- XAMPP
- Apache
- MySQL
- PHP 8+

## Setup
1. Copy the `FreelanceMarketplace` folder into `C:/xampp/htdocs/`.
2. Start Apache and MySQL from XAMPP.
3. Open phpMyAdmin.
4. Import `database/schema.sql`.
5. Visit `http://localhost/FreelanceMarketplace/`.
6. Register a seller account and a buyer account.
7. Login as seller -> Post Gig.
8. Login as buyer -> order the gig.
9. Seller -> Mark Delivered.
10. Buyer -> Release Payment.
11. Buyer -> submit rating/review.

## Note
The payment system is a simulation for academic purposes. It does not process real money.

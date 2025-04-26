Wallet System (Pure PHP + File-based JSON Storage)

This project is a simple wallet system implemented using **pure PHP**, **HTML/CSS/JavaScript**, and **file-based JSON** storage.

Access via Browser for frontend :-
"http://localhost/Wallet-System/frontend/index.html"

**Assumptions Made**

* Users must have a valid email address.
* DOB must be a past date (cannot be today or future).
* No negative deposits or withdrawals allowed.
* Withdrawal amount cannot exceed user's balance.
* All data is stored locally in users.json and transactions.json.
* Each user ID is based on username + unique ID for readability.

**How to Test**

* Create a new user using the Create User page or api.
* Deposit money using the Deposit page:
    :-Negative amount (should error)
    :-Valid deposit (should succeed)
* Withdraw money using the Withdraw page:
    :-Withdraw more than balance (should error)
    :-Valid withdraw (should succeed)
* Check user's balance and transactions using Check Balance page.
* Inspect /data/users.json and /data/transactions.json to verify data storage.

**API**

* Deposit (POST)
http://localhost/Wallet-System/api/deposit

:- body
   {
    "user_id": "user_id",
    "amount": amount
   }

* Withdraw (POST)
http://localhost/Wallet-System/api/withdraw

:- body
   {
    "user_id": "user_id",
    "amount": amount
   }

* Balance (GET)
http://localhost/Wallet-System/api/balance?user_id=user_id

* Transaction (GET)
http://localhost/Wallet-System/api/transactions?user_id=user_id

* Create User (POST)
http://localhost/Wallet-System/api/create_user

:-body
    {
    "name": "John Doe",
    "email": "john.doe@example.com",
    "password": "12345678",
    "dob": "1995-05-05"
    }
* User List (GET)
http://localhost/Wallet-System/api/users



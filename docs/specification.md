# Project Specification

<strong>Application description:</strong>
The idea is to build a small CRM (Custom Relationship Management) software for a company that specializes in connecting their clients with banks and lenders that can
provide them with two types of loans:
1. Cash loan
2. Home loan

<strong>The business flow is as follows:</strong>
1. The client calls in and leaves his details over the phone to an advisor
2. Advisor takes client's data and enters it into the system
3. Advisor fills in loan application data for a loan that the client chose
(cash/home, or both)
4. At the end of the day, advisors want to make a report of clients and products that they have entered in so far

<hr />

### Database structure

This is how the db structure should look like, together with its integrity:
- [x] `roles` table for different types of users in the app - roles with different level of authorization: 'user' and 'advisor' will bi used for this case. The 'user' role is with the lowest level of permissions; the 'advisor' role has much higher level of permissions. All setting related to roles will be in Role model.
- [x] advisors will be stored in `users` table with a appropriate role ID.
- [x] `clients` table for storing clients. It will have very basic attributes (columns): first and last name, email, phone, address, and advisor_id as a FK constraint to the `user` table.
- [x] `cash_loan_products` table for storing the data about cash loans for clients. It will have the next attributes (columns):
    - client_id - an unique FK constraint to the `clients` table
    - loan_amount - decimal number for the amount of the required loan.
- [x] `home_loan_products` table for storing the data about home loans for clients. It will have the next attributes (columns):
    - client_id - an unique FK constraint to the `clients` table
    - property_value - decimal number for a property value
    - down_payment - decimal number for the amount of the down payment

<hr />

### Application structure

- [x] Role model
- [x] Client model
- [x] HomeLoanProduct model
- [x] CashLoanProduct model

##### Relationships
- [x] role - advisor - ONE TO ONE
- [x] client - advisor - ONE TO ONE
- [x] advisor - clients - ONE TO MANY
- [x] client - cash_loan_product - ONE TO ONE
- [x] client - home_loan_product - ONE TO ONE
- [x] advisor - home_loan_product - HAS ONE THROUGH (if needed)

### Back end
- [x] User authentication
- [x] Advisor authorization:
    - [x] Advisor can view all clients (no restrictions)
    - [x] Advisor can not update a client’s product, if that product is assigned to a different advisor
    - [x] When compiling the report, only products of the currently logged-in advisor must be used
- [x] Client management
    - [x] Show all clients
    - [x] CRUD on a client by an advisor
        - [x] create a client
        - [x] update a client
        - [x] delete a client
        - [x] add/update cash loan
        - [x] add/update home loan and property value
- [x] Data validation at the DB level and app level (front and back end)
- [x] Generate a report for an advisor

### Front end
- Login page:
    - [x] email and password
    - [x] After a successful login, take the advisor to the `Dashboard` page.
<br />
- Advisor dashboard page:
    - [x] Contains a link to `View All Clients` - menu item `Clients`
    - [x] Contains a link to `View Report` - menu item `Report`
    - [x] `Logout` button - already implemented with application scaffolding.
<br />
- View all client's page:
    - [x] `Go back to dashboard` button
    - [x] `Create A Client` button
    - [x] A list of clients from the database, represented through a table, with the following columns:
        - [x] First name
        - [x] Last name
        - [x] Email
        - [x] Phone
        - [x] Cash loan (yes/no - if the client has applied)
        - [x] Home loan (yes/no - if the client has applied)
        - [x] Actions
        - [x] Edit button -> Should open an edit page for that client
        - [x] Delete button -> Should delete that client
<br />
- Create client page:
    - [x] `Go back to clients` button
    - [x] A basic page with a form with all of the fields needed to create the
    client
    - [x] First name and last name are always required, and <strong>at least an email or a phone is required</strong>.
<br />
- Edit client page
    - [x] `Go back to clients` button
    - [x] Display a form with loaded client data, through which clients can be updated.
        - [x] First name and last name are required always, and <strong>at least an email or a phone is required</strong>
    - [x] Display a form for filling in the Cash loan application for the loaded
    client (both create and update)
        - [x] Client ID is the client being edited
        - [x] Advisor ID is the advisor currently logged in
    - [x] Display a form for filling in the Home loan application for the loaded client (both create and update)
        - [x] Client ID is the client being edited
        - [x] Advisor ID is the advisor currently logged in

- View report page:
    - [x] Display a single table, with the following columns:
        - [x] Product type (Cash loan / Home loan)
        - [x] Product value
            - [x] For cash loans, the loan amount
            - [x] For home loans, property value - down payment amount
        - [x] Creation date
    - [x] Order the report by creation date, from newest to oldest
    - [x] This report should contain only the products that belong to the currently logged-in advisor
    - [ ] (✨ Bonus points) Enable advisors to export this report to CSV

# Tasks - workflow

- [x] Set up project structure
- [x] Implement authentication
- [x] Add the Role entity in the app
- [x] Create `roles` table with a seeder
- [x] Add the Client entity in the app
- [x] Create `clients` table with a seeder
- [x] Add the HomeLoanProduct entity in the app
- [x] Create `home_loan_products` table with a seeder
- [x] Add the CashLoanProduct entity in the app
- [x] Create `cash_loan_products` table with a seeder
- [x] Develop client management module (CRUD by advisor)
- [x] Generate reports: implement business logic for report generation for an auth advisor
- [x] Create advisor profile page (already exists in the system)
- [x] Design `Login Page`: layout, FE validation
- [ ] Design `Dashboard`: implement required links in the main menu
- [x] Design `All Clients` page
- [x] Design `Create Client` page
- [x] Design `Edit Client` page
- [x] Design `View Report` page
- [ ] Write unit and e2e tests (if needed)


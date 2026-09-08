# Data Constraints
This document is about what kind of data is used as input data in the system and how this data is constrained.
Important: Since data in new "head" is unknown, very little constraints are set.
All of those constraints have been discussed and approved with the customer.

Important Info: If not "optional", a field is "required"

## Customer
1. Company Name
   - no constraints
3. Registration number
   - must be unique
4. VAT number
   - decimal number
   - between 0.00 and 0.99
5. Mail address
   - no constraints
6. Phone number
   - optional
   - no constraints (since letters, spaces, braces and numbers could all be part of the phone number)
7. website
   - optional
   - no constraints
8. Address (all infos below)

Additionally: Customer has "Active" field:
- not set at start
- only changed when activating/ deactivating customer
- default is "active"

## Address Information
1. Country
   - text
2. City
   - text
3. Postal Code/ ZIP Code
   - number
4. Street name
   - text
5. (address) number
   - no constraints (since all kind of numbers, letters and special signs such as "," or "-" can be part of that)
6. additional address information
   - optional
   - no constraints

## Solution
1. (Solution) Number
   - unique
2. Title
   - no constraints
3. Category
   -  no constraints
4. Description
   - no constraints
5. VAT-Rate
   - decimal number
   - between 0.00 and 0.99
6. Units
   - optional!
   - number
   - must be bigger than 0
7. Price per Unit
   - optional!
   - number (in Euro)
   - must be 0 or higher
   - optional (if not set, default price is used)
8. Recurring Period
   - optional!
   - number
   - must be bigger 
9. Unit of Recurring Period
   - optional!
   - select: day(s), week(s), month(s), years(s)
10. Additional Information
   - no constraints
   - optional
     
## Solution (when assigned! Most optional fields must be filled in now.)
1. (Solution) Number
   - unique
2. Title
   - no constraints
3. Category
   -  3 Options: Domain, Product, Service
4. Description
   - no constraints
5. VAT-Rate
   - decimal number
   - between 0.00 and 0.99
6. Units
   - number
   - must be bigger than 0
7. Price per Unit
   - number (in Euro)
   - must be 0 or higher
   - optional (if not set, default price is used)
8. Recurring Period
   - number
   - must be bigger 
9. Unit of Recurring Period
   - select: day(s), week(s), month(s), years(s)
10. start date
   - "date" type
11. end date
   - "date" type
   - can't be before start date
   - optional
12. Additional Information
   - no constraints
   - optional
   
Additionally:
1. Units, Price per Unit and VAT Rate are either:
   - ALL there (default price possible) or...
   - ALL NOT there AND all other fields empty.
2. If the solution is a "One-Time-Payment":
   - Recurring Period, Unit of Recurring Period and Start Date need to be empty.

## Contact Person
1. First name
   - text
2. Middle name
   - text
   - optional
3. Last name
   - text
4. Email
   - unique per customer
   - no constraints
5. Phone number
   - optional
6. Function
   - no constraints

## GitLab Project
1. GitLab-Project ID:
   - List of all available Projects to choose from.
   - no requirements for structure of ID
3. Name:
   - no requirements

## Ticket
1. Title
   - no constraints
2. Category
   - Dropdown-Menu: Issue, Bug
3. Description
   - no constraints
4. GitLab-Project ID:
   - List of all available Projects to choose from.
   - no requirements for structure of ID


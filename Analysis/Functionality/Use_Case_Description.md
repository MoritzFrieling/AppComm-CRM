(Additional Information about input can be found in the "Data Constraints" File)

# Use Cases

## CRUD Customer + (De)activation + Overview

### Create Customer

| Name:          | _Create Customer_                                                                                                                                                                                                                                                            |
|----------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| Actor:         | Administrator                                                                                                                                                                                                                                                                |
| Description:   | Create a customer profile with general information                                                                                                                                                                                                                           |
| Pre-condition: | Administrator is on general Customer Overview page.                                                                                                                                                                                                                          |
| Scenario:      | 1. Administrator indicates that a new customer needs to be added.                                                                                                                                                                                                            |
|                | 2. System displays general information form, containing: Company (Name), Registration Number(unique), VAT Number, adress (Country, City, ZIP Code, Street, number, additional adress information(optional)), general mail adress, phone number (optional), website(optional) |
|                | 3. Administrator fills the necessary fields in and saves the form.                                                                                                                                                                                                           |
|                | 4. System indicates that the customer has been saved.                                                                                                                                                                                                                        |
| Results:       | A new customer has successfully been added.                                                                                                                                                                                                                                  |
| Exceptions:    | 4.a. Missing data                                                                                                                                                                                                                                                            |
|                | 4.a.1 System indicates that data is missing in certain fields.                                                                                                                                                                                                               |
|                | 4.a.2 Go back to step 2.                                                                                                                                                                                                                                                     |
|                | 4.b. Incorrect data                                                                                                                                                                                                                                                          |
|                | 4.b.1 System indicates data is incorrect in certain fields.                                                                                                                                                                                                                  |
|                | 4.b.2 Go back to step 2.                                                                                                                                                                                                                                                     |
|                | 4.c. Customer already exists                                                                                                                                                                                                                                                 |
|                | 4.c.1 System indicates that the registration number is already present in system.                                                                                                                                                                                            |
|                | 4.c.2 Go back to step 2.                                                                                                                                                                                                                                                     |

### Read Customer

| Name:          | _Read Customer_                                                                                 |
|----------------|-------------------------------------------------------------------------------------------------|
| Actor:         | Administrator                                                                                   |
| Description:   | Administrator looks at specific Customer                                                        |
| Pre-condition: | Administrator is on the general overview page of all customers                                  |
| Scenario:      | 1. System displays the general overview page.                                                   |
|                | 2. Administrator clicks on specific customer                                                    |
|                | 3. System opens this specific customers page and displays the information to the administrator. |
| Results:       | Administrator can see a customers information                                                   |

### Update Customer

| Name:          | _Update Customer_                                                                                 |
|----------------|---------------------------------------------------------------------------------------------------|
| Actor:         | Administrator                                                                                     |
| Description:   | Administrator wants to change a specific customer's information                                   |
| Pre-condition: | Administrator is on the page of a specific customer                                               |
| Scenario:      | 1. Administrator indicates that the customer information need to be updated                       |
|                | 2. System makes the fields editable                                                               |
|                | 3. Administrator makes changes to the fields and indicates the system to save the changes.        |
|                | 4. System indicates that the customer has been saved.                                             |
| Results:       | The customer's information got altered successfully.                                              |
| Exceptions:    | 4.a. Missing data                                                                                 |
|                | 4.a.1 System indicates that data is missing in certain fields.                                    |
|                | 4.a.2 Go back to step 2.                                                                          |
|                | 4.b. Customer already exists                                                                      |
|                | 4.b.1 System indicates that the Registration Number of the customer is already present in system. |
|                | 4.b.2 Go back to step 2.                                                                          |
|                | 4.c. Incorrect data                                                                               |
|                | 4.c.1 System indicates dats is incorrect in certain fields.                                       |
|                | 4.c.2 Go back to step 2.                                                                          |

### Delete Customer

| Name:          | _Delete Customer_                                                                         |
|----------------|-------------------------------------------------------------------------------------------|
| Actor:         | Administrator                                                                             |
| Description:   | Administrator wants to delete customer from the system                                    |
| Pre-condition: | Administrator is on the update page of a specific customer                                |
| Scenario:      | 1. Administrator indicates that specific customer should be deleted.                      |
|                | 2. System warns the administrator by pointing out that this can't be undone.              |
|                | 3. Administrator confirms the deletion.                                                   |
|                | 4. System indicates that the customer has been deleted, with all the information present. |
| Results:       | Customer was successfully deleted.                                                        |
| Exceptions:    | 3.a. Administrator cancels the process                                                    |
|                | 3.a.1 Administrator denies the deletion.                                                  |
|                | 3.a.2 Use Case ends here.                                                                 |

### Deactivate Customer

| Name:          | _Deactivate Customer_                                                            |
|----------------|----------------------------------------------------------------------------------|
| Actor:         | Administrator                                                                    |
| Description:   | Customer should lose access to the system                                        |
| Pre-condition: | Administrator is on the update page of a specific customer                       |
| Scenario:      | 1. Administrator indicates customer should be deactivated.                       |
|                | 2. Sytem warns the administrator and points out this deactivation can be undone. |
|                | 3. Administrator confirms the deactivation.                                      |
|                | 4. System indicates that the customer was deactivated.                           |
| Results:       | Customer was succesfully deactivated.                                            |
| Exceptions:    | 3.a. Admin cancells process                                                      |
|                | 3.a.1 Administrator denies the deactivation.                                     |
|                | 3.a.2 Use Case ends here.                                                        |

### Activate Customer

| Name:          | _Activate Customer_                                          |
|----------------|--------------------------------------------------------------|
| Actor:         | Administrator                                                |
| Description:   | Customer should regain access to the system                  |
| Pre-condition: | Administrator is on the update page of a specific customer   |
| Scenario:      | 1. Administrator indicates customer should be activated.     |
|                | 2. Sytem asks the admin to make sure this action is correct. |
|                | 3. Administrator confirms the activation.                    |
|                | 4. System indicates that the customer was activated.         |
| Results:       | Customer was succesfully activated.                          |
| Exceptions:    | 3.a. Admin cancells process                                  |
|                | 3.a.1 Administrator denies the activation.                   |
|                | 3.a.2 Use Case ends here.                                    |

### View Customers Overview

| Name:          | _View Customers Overview_                                                                                                                  |
|----------------|--------------------------------------------------------------------------------------------------------------------------------------------|
| Actor:         | Administrator                                                                                                                              |
| Description:   | View, filter and sort multiple customers                                                                                                   |
| Pre-condition: | Administrator is logged in.                                                                                                                |
| Scenario:      | 1. Administrator indicates he wants to go to the general Customer Overview Page.                                                           |
|                | 2. System displays all the customers with their following information: company title, registration number, location details (in one field) |
|                | 3. Admin views all the information                                                                                                         |
| Results:       |                                                                                                                                            |
| Extension:     | 3.a. Administrator wants to filter                                                                                                         |
|                | 3.a.1 Admin indicates he wants to filter the customers.                                                                                    |
|                | 3.a.2 System gives the admin the option to filter the customers based on the fields displayed.                                             |
|                | 3.a.3 Admin selects the specific filters.                                                                                                  |
|                | 3.a.4 Return to step 1.                                                                                                                    |
|                | 3.b. Administrator wants to sort                                                                                                           |
|                | 3.b.1 Admin indicates he wants to sort the customers.                                                                                      |
|                | 3.b.2 System gives the admin the option to sort the customers based on the fields displayed.                                               |
|                | 3.b.3 Admin selects the specific sorting option.                                                                                           |
|                | 3.b.4 Return to step 1.                                                                                                                    |

## CRUD Solution + (Un)assign + Overview

### Create Solution

| Name:          | _Create Solution_                                                                                                                                 |
|----------------|---------------------------------------------------------------------------------------------------------------------------------------------------|
| Actor:         | Administrator                                                                                                                                     |
| Description:   | Create a Solution with general information for a specific customer                                                                                |
| Pre-condition: | Administrator is on the general Solution overview page                                                                                            |
| Scenario:      | 1. Administrator indicates that a new Solution needs to be added                                                                                  |
|                | 2. System displays general information form, containing: number(plain number, unique), category(service/product/domain name), title, description. |
|                | 3. Administrator fills the necessary fields in and saves the form.                                                                                |
|                | 4. System indicates that the Solution has been saved.                                                                                             |
| Results:       | A new Solution has successfully been added to the database.                                                                                       |
| Exceptions:    | 4.a. Missing data                                                                                                                                 |
|                | 4.a.1 System indicates that data is missing in certain fields.                                                                                    |
|                | 4.a.2 Go back to step 2.                                                                                                                          |
|                | 4.b. Incorrect data                                                                                                                               |
|                | 4.b.1 System indicates dats is incorrect in certain fields.                                                                                       |
|                | 4.b.2 Go back to step 2.                                                                                                                          |
|                | 4.c. Solution already exists                                                                                                                      |
|                | 4.c.1 System indicates Solution number is already present in system.                                                                              |
|                | 4.c.2 Go back to step 2.                                                                                                                          |

### Read Solution

| Name:          | _Read Solution_                                                                                  |
|----------------|--------------------------------------------------------------------------------------------------|
| Actor:         | Administrator                                                                                    |
| Description:   | Administrator looks at specific Solution                                                         |
| Pre-condition: | Administrator is on the general Solution overview page                                           |
| Scenario:      | 1. System displays the overview page.                                                            |
|                | 2. Administrator clicks on specific Solution                                                     |
|                | 3. System opens this specific Solution's page and displays the information to the administrator. |
| Results:       | Administrator can see a Solutions information                                                    |

### Update Solution

| Name:          | _Update Solution_                                                                          |
|----------------|--------------------------------------------------------------------------------------------|
| Actor:         | Administrator                                                                              |
| Description:   | Administrator wants to change information of a specific Solution                           |
| Pre-condition: | Administrator is on a specific Solution overview page                                      |
| Scenario:      | 1. Administrator indicates that the Solution information need to be updated                |
|                | 2. System makes the fields editable                                                        |
|                | 3. Administrator makes changes to the fields and indicates the system to save the changes. |
|                | 4. System indicates that the Solution has been saved.                                      |
| Results:       | The Solution's information got altered successfully.                                       |
| Exceptions:    | 4.a. Missing data                                                                          |
|                | 4.a.1 System indicates that data is missing in certain fields.                             |
|                | 4.a.2 Go back to step 2.                                                                   |
|                | 4.b. Incorrect data                                                                        |
|                | 4.b.1 System indicates dats is incorrect in certain fields.                                |
|                | 4.b.2 Go back to step 2.                                                                   |
|                | 4.c. Solution already exists                                                               |
|                | 4.c.1 System indicates that the updated Solution is already present in system.             |
|                | 4.c.2 Go back to step 2.                                                                   |

### Delete Solution

| Name:          | _Delete Solution_                                                                         |
|----------------|-------------------------------------------------------------------------------------------|
| Actor:         | Administrator                                                                             |
| Description:   | Administrator wants to delete Solution from the system                                    |
| Pre-condition: | Administrator is on a specific Solution update page                                       |    
| Scenario:      | 1.Administrator indicates that specific Solution should be deleted.                       |
|                | 2. System warns the administrator by pointing out that this can't be undone.              |
|                | 3. Administrator confirms the deletion.                                                   |
|                | 4. System indicates that the Solution has been deleted, with all the information present. |
| Results:       | Solution was successfully deleted.                                                        |
| Exceptions:    | 2.a. Customer still assigned                                                              |
|                | 2.a.1 Systems warns that the solution cannot be deleted because it's still assigned       |
|                | 2.a.2 Use Case ends here.                                                                 |
|                | 3.a. Administrator cancels the process                                                    |
|                | 3.a.1 Administrator denies the deletion.                                                  |
|                | 3.a.2 Use Case ends here.                                                                 |

### View Solution Overview

| Name:          | _View Solution Overview_                                                                                                                           |
|----------------|----------------------------------------------------------------------------------------------------------------------------------------------------|
| Actor:         | Administrator                                                                                                                                      |
| Description:   | View, filter and sort multiple solutions                                                                                                           |
| Pre-condition: | Administrator is logged in.                                                                                                                        |
| Scenario:      | 1. Administrator indicates he wants to view the general Solution Overview page.                                                                    |
|                | 2. System displays all the solutions with their following information: number(plain number, unique), category(service/product/domain name), title. |
|                | 3. Admin views all the information .                                                                                                               | 
| Results:       | Administrator can sucessfully view Solution Overview                                                                                               |
| Extension:     | 3.a. Administrator wants to filter                                                                                                                 |
|                | 3.a.1 Admin indicates he wants to filter the solutions.                                                                                            |
|                | 3.a.2 System gives the admin the option to filter the solutions based on the fields displayed.                                                     |
|                | 3.a.3 Admin selects the specific filters.                                                                                                          |
|                | 3.a.4 Return to step 1.                                                                                                                            |
|                | 3.b. Administrator wants to sort                                                                                                                   |
|                | 3.b.1 Admin indicates he wants to sort the solution.                                                                                               |
|                | 3.b.2 System gives the admin the option to sort the solutions based on the fields displayed.                                                       |
|                | 3.b.3 Admin selects the specific sorting option.                                                                                                   |
|                | 3.b.4 Return to step 1.                                                                                                                            |

### Assign Solution

| Name:          | _Assign Solution_                                                                                                                                                                                                 |
|----------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| Actor:         | Administrator                                                                                                                                                                                                     |
| Description:   | Administrator wants to assign a Solution to a customer                                                                                                                                                            |
| Pre-condition: | Administrator is on the overview page of a specific customer                                                                                                                                                      |
| Scenario:      | 1.Administrator indicates that a solution needs to be assigned to a customer.                                                                                                                                     |
|                | 2. System displays a list of available solutions.                                                                                                                                                                 |
|                | 3. Administrator selects the desired solution to assign.                                                                                                                                                          |
|                | 4. System displays additional price information fields (required now): price, units, recurring period, unit of recurring periods, one time payment, VAT rate, start and end date, additional information (free form text input). |
|                | 5. Administrator fills out the fields and saves it.                                                                                                                                                               |
|                | 6. System associates the solution with the customer                                                                                                                                                               |
| Results:       | Solution was successfully assigned to a customer.                                                                                                                                                                 |
| Exceptions:    | 6.a. Missing data                                                                                                                                                                                                 |
|                | 6.a.1 System indicates that data is missing in certain fields.                                                                                                                                                    |
|                | 6.a.2 Go back to step 4.                                                                                                                                                                                          |
|                | 6.b. Incorrect data                                                                                                                                                                                               |
|                | 6.b.1 System indicates dats is incorrect in certain fields.                                                                                                                                                       |
|                | 6.b.2 Go back to step 4.                                                                                                                                                                                          |

### Unassign Solution from Customer

| Name:          | _Unassign Solution from Customer_                                                |
|----------------|----------------------------------------------------------------------------------|
| Actor:         | Administrator                                                                    |
| Description:   | Administrator wants to unassign Solution from a customer                         |
| Pre-condition: | Administrator is on the overview page of a specific customer                     |
| Scenario:      | 1. Administrator indicates that a solution should be unassigned from a customer. |
|                | 2. System asks for confirmation of the unassignment.                             |
|                | 3. Administrator confirms the unassignment.                                      |
|                | 4. System disassociates the solution from the customer.                          |
| Results:       | The solution has been successfully unassigned from the customer.                 |
| Exceptions:    | 3.a. Administrator cancels the process                                           |
|                | 3.a.1 Administrator denies the confirmation request.                             |
|                | 3.a.2 Use Case ends here.                                                        |

## CRUD Contact Person

### Create Contact Person

| Name:          | _Create Contact Person_                                                                                                                                               |
|----------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| Actor:         | Administrator                                                                                                                                                         |
| Description:   | Create a Contact person profile with general information                                                                                                              |
| Pre-condition: | Administrator is on customer's specific page                                                                                                                          |
| Scenario:      | 1. Administrator indicates that a new contact person needs to be added                                                                                                |
|                | 2. System displays general information form, containing: Last Name, First Name, Middle name(s), email(unique), phone number, Function/ Role, description (relational) |
|                | 3. Administrator fills the necessary fields in and saves the form.                                                                                                    |
|                | 4. System indicates that the contact person has been saved.                                                                                                           |
| Results:       | A new contact person has successfully been added to the database.                                                                                                     |
| Exceptions:    | 4.a. Missing data                                                                                                                                                     |
|                | 4.a.1 System indicates that data is missing in certain fields.                                                                                                        |
|                | 4.a.2 Go back to step 2.                                                                                                                                              |
|                | 4.b. Incorrect data                                                                                                                                                   |
|                | 4.b.1 System indicates dats is incorrect in certain fields.                                                                                                           |
|                | 4.b.2 Go back to step 2.                                                                                                                                              |
|                | 4.c. Contact person already exists                                                                                                                                    |
|                | 4.c.1 System indicates contact person is already present in system (due to the same email-adress).                                                                    |
|                | 4.c.2 Go back to step 2.                                                                                                                                              |


### Read Contact Person

| Name:          | _Read Contact Person_                                                                          |
|----------------|------------------------------------------------------------------------------------------------|
| Actor:         | Administrator                                                                                  |
| Description:   | Administrator looks at specific contact person                                                 |
| Pre-condition: | Administrator is on the page of a specific customer                                            |
| Scenario:      | 1. System displays the customer's page.                                                        |
|                | 2. Administrator indicates he wants to view the contact person's information.                  |
|                | 3. System opens this specific person's page and displays the information to the administrator. |
| Results:       | Administrator can see a contact person's information                                           |

### Update Contact Person

| Name:          | _Update Contact Person_                                                                    |
|----------------|--------------------------------------------------------------------------------------------|
| Actor:         | Administrator                                                                              |
| Description:   | Administrator wants to change information of a specific contact person of a customer       |
| Pre-condition: | Administrator is on the page of a contact person of a specific customer                    |
| Scenario:      | 1. Administrator indicates that the contact person's information need to be updated        |
|                | 2. System makes the fields editable                                                        |
|                | 3. Administrator makes changes to the fields and indicates the system to save the changes. |
|                | 4. System indicates that the contact person has been saved.                                |
| Results:       | The contact person's information got altered successfully.                                 |
| Exceptions:    | 4.a. Missing data                                                                          |
|                | 4.a.1 System indicates that data is missing in certain fields.                             |
|                | 4.a.2 Go back to step 2.                                                                   |
|                | 4.b. Incorrect data                                                                        |
|                | 4.b.1 System indicates dats is incorrect in certain fields.                                |
|                | 4.b.2 Go back to step 2.                                                                   |
|                | 4.c. Contact person already exists                                                         |
|                | 4.c.1 System indicates that the updated contact person is already present in system.       |
|                | 4.c.2 Go back to step 2.                                                                   |

### Delete Contact Person

| Name:          | _Delete Contact Person_                                                                  |
|----------------|------------------------------------------------------------------------------------------|
| Actor:         | Administrator                                                                            |
| Description:   | Administrator wants to delete Solution from the system                                   |
| Pre-condition: | Administrator is on the update page of a contact person of a specific customer           |
| Scenario:      | 1.Administrator indicates that the contact person should be deleted.                     |
|                | 2. System warns the administrator by pointing out that this can't be undone.             |
|                | 3. Administrator confirms the deletion.                                                  |
|                | 4. System indicates that the contact has been deleted, with all the information present. |
| Results:       | Contact person was successfully deleted.                                                 |
| Exceptions:    | 3.a. Administrator cancels the process                                                   |
|                | 3.a.1 Administrator denies the deletion.                                                 |
|                | 3.a.2 Use Case ends here.                                                                |

## Use Case(s) Ticket System
### Assign GitLab Project
| Name: | _Assign GitLab Project_ |
|----|----|
| Actor: | Administrator |
| Description: | Administrator wants to assign a GitLab project to a customer |
| Pre-condition: | Administrator is on the overview page of a specific customer |
| Scenario: |1. Administrator indicates that a GitLab project needs to be assigned to a customer.  |
|  | 2. System displays a list(dropdown) of all available GitLab projects of AppComm.  |
|  | 3. Administrator selects the desired GitLab project and indicates to assign it. |
|  | 4. System associates the GitLab project with the customer. |
| Results: | GitLab project was successfully assigned to a customer.|
| Exceptions: | 3.a. Cancellation of process|
|  | 3.a.1 Administrator selects the project and then cancels.|
|  | 3.a.2 Use Case ends here.|

### Unassign GitLab Project
| Name: | _Unassign GitLab Project_ |
|----|----|
| Actor: | Administrator |
| Description: | Administrator wants to unassign a previously assigned GitLab project from a customer |
| Pre-condition: | Administrator is on specific customer's page |
| Scenario: |1. Administrator indicates a specifc GitLab project should be unassigned from a customer. |
|  | 2. System asks for confirmation of the unassignment.  |
|  | 3. Administrator confirms the unassignment. |
|  | 4. System disassociates the GitLab project from the customer. |
| Results: | The GitLab project has been successfully unassigned from the customer.|
| Exceptions: | 3.a. Administrator cancels the process |
|  | 3.a.1 Administrator denies the confirmation request.  |
|  | 3.a.2 Use Case ends here. |

### Write Ticket
| Name: | _Write Ticket_ |
|----|----|
| Actor: | Administrator |
| Description: | Administrator wants to add a new ticket via GitLab |
| Pre-condition: | Administrator is on specific customer's page |
| Scenario: |1. Administrator indicates a new ticket should be created in GitLab for the specific customer. |
|  | 2. Sytem displays a list(dropdown) of assigned GitLab projects for this customer as well as a form with a title, a category and a description for the ticket.  |
|  | 3. Administrator chooses the specific GitLab project, fills in the fields, chooses the category and saves the ticket. |
|  | 4. System indicates that the ticket was created in GitLab. |
| Results: | Ticket was succesfully created.|
| Exceptions: | 4.a. Missing data |
|  | 4.a.1 System indicates that data is missing in certain fields. |
|  | 4.a.2 Go back to step 2. |


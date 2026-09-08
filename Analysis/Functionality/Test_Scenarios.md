# Test Scenarios

## Create Customer

| Name:     | Administrator creates customer with missing information|
|-----------|----------------------------------------------|
| Scenario: | 1. Administrator indicates that a new customer needs to be added.|
|           | 2. System ask for general customer information: Company (Name), Registration Number(unique), VAT Number, address (Country, City, ZIP Code, Street, number, additional address information(optional)), general mail address, phone number (optional), website(optional).                                                |
|           | 3. Administrator fills in the following information: "Company X" as the name, "123456789" as the Registration number, "Netherlands, Venlo, 11245, Hagelseweg, 12a, 1. Floor" for the address, "companyx@web.com" as mail address, leaves the optional phone number and website out and indicates to save the customer. |
|           | 4. System indicates that the required field "VAT Number" is empty.|
| Results:  | Customer creation failed.|

| Name:     | Administrator creates customer with incorrect data|
|-----------|--------------------------------------------------------------------------------------------|
| Scenario: | 1. Administrator indicates that a new customer needs to be added.|
|           | 2. System ask for general customer information: Company (Name), Registration Number(unique), VAT Number, address (Country, City, ZIP Code, Street, number, additional address information(optional)), general mail address, phone number (optional), website(optional).                                                                                   |
|           | 3. Administrator fills in the following information: "Company X" as the name, "NL123456789B1234" as VAT number, "123456789" as the Registration number, "Netherlands, Venlo, 11245, Hagelseweg, 12a, 1. Floor", for the address, "companyx@web.com" as mail address, leaves the optional phone number and website out and indicates to save the customer. |
|           | 4. System indicates that the VAT number is not valid.|
| Results:  | Customer creation failed.|

| Name:     | Administrator creates customer who already exists|
|-----------|-------------------------------------------------------------------------------------|
| Scenario: | 1. Administrator indicates that a new customer needs to be added.|
|           | 2. System ask for general customer information: Company (Name), Registration Number(unique), VAT Number, address (Country, City, ZIP Code, Street, number, additional address information(optional)), general mail address, phone number (optional), website(optional).                                                                                 |
|           | 3. Administrator fills in the following information: "Company X" as the name, "NL123456789B12" as VAT number, "123456789" as the Registration number, "Netherlands, Venlo, 11245, Hagelseweg, 12a, 1. Floor", for the address, "companyx@web.com" as mail address, leaves the optional phone number and website out and indicates to save the customer. |
|           | 4. System indicates that the customer is already present in the database.|
| Results:  | Customer creation failed.|

| Name:     | Administrator successfully creates customer|
|-----------|------------------------------------------------------------------|
| Scenario: | 1. Administrator indicates that a new customer needs to be added.|
|           | 2. System ask for general customer information: Company (Name), Registration Number(unique), VAT Number, address (Country, City, ZIP Code, Street, number, additional address information(optional)), general mail address, phone number (optional), website(optional).|
|           | 3. Administrator fills in the following information: "Company X" as the name, "NL123456789B12" as VAT number, "123456789" as the Registration number, "Netherlands, Venlo, 11245, Hagelseweg, 12a, 1. Floor", for the address, "companyx@web.com" as mail address, leaves the optional phone number and website out and indicates to save the customer. |
|           | 4. System indicates that the customer got successfully added to the database.|
| Results:  | Customer creation successful.|

## Read Customer

| Name:     | Administrator wants to view a specific customer                                             |
|-----------|---------------------------------------------------------------------------------------------|
| Scenario: | 1. System displays the overview page.                                                       |
|           | 2. Administrator clicks on "Company X".                                                     |
|           | 3. System opens the page  of "Company X" and displays the information to the administrator. |
| Results:  | Administrator can successfully see a customers information                                  |

## Update Customer

| Name:     | Updating customer with missing data                                                      |
|-----------|------------------------------------------------------------------------------------------|
| Scenario: | 1. Administrator indicates that the customer information need to be updated              |
|           | 2. System makes the fields editable                                                      |
|           | 3. Administrator deletes the customer name and indicates the system to save the changes. |
|           | 4. System indicates that data is missing in certain fields.                              |
| Results:  | The customer's information were not altered successfully.                                |

| Name:     | Updating customer with already present data|
|-----------|-----------------------|
| Scenario: | 1. Administrator indicates that the customer information need to be updated|
|           | 2. System makes the fields editable|
|           | 3. Administrator changes the Registration Number to "012345678" and indicates the system to save the changes. |
|           | 4. System indicates that the Registration Number is already present in the system.|
| Results:  | The customer's information were not altered successfully.|

| Name:     | Updating customer with incorrect data|
|-----------|-------------------------------------------------|
| Scenario: | 1. Administrator indicates that the customer information need to be updated|
|           | 2. System makes the fields editable|
|           | 3. Administrator changes the country from "Netherlands" to "1234" and indicates the system to save the changes. |
|           | 4. System indicates that the customer's mail address is incorrect.|
| Results:  | The customer's information were not altered successfully.|

| Name:     | Administrator successfully updates customer|
|-----------|------------------------------------------------------------|
| Scenario: | 1. Administrator indicates that the customer information need to be updated|
|           | 2. System makes the fields editable|
|           | 3. Administrator changes the email address from "albert.i@drago.nl" to "albert.ib@drago.nl" and indicates the system to save the changes. |
|           | 4. System indicates that the customer has been saved.|
| Results:  | The customer's information were  altered successfully.|

## Delete Customer

| Name:     | Administrator denies to delete customer                                      |
|-----------|------------------------------------------------------------------------------|
| Scenario: | 1.Administrator indicates that the customer "Company X" should be deleted.   |
|           | 2. System warns the administrator by pointing out that this can't be undone. |
|           | 3. Administrator denies the deletion.                                        |
|           | 4. System indicates that the customer has not been deleted.                  |
| Results:  | Deletion of customer not successful.                                         |

| Name:     | Administrator successfully deletes customer                                               |
|-----------|-------------------------------------------------------------------------------------------|
| Scenario: | 1.Administrator indicates that the customer "Company X" should be deleted.                |
|           | 2. System warns the administrator by pointing out that this can't be undone.              |
|           | 3. Administrator confirms the deletion.                                                   |
|           | 4. System indicates that the customer has been deleted, with all the information present. |
| Results:  | Deletion of customer successful.                                                          |

## Deactivate Customer

| Name:     | Administrator denies to deactivate customer                                    |
|-----------|--------------------------------------------------------------------------------|
| Scenario: | 1.Administrator indicates that the customer "Company X" should be deactivated. |
|           | 2. System warns the administrator by pointing out that this can be undone.     |
|           | 3. Administrator denies the deactivation.                                      |
|           | 4. System indicates that the customer has not been deactivated.                |
| Results:  | Deactivation of customer not successful.                                       |

| Name:     | Administrator successfully deactivates customer                                |
|-----------|--------------------------------------------------------------------------------|
| Scenario: | 1.Administrator indicates that the customer "Company X" should be deactivated. |
|           | 2. System warns the administrator by pointing out that this can be undone.     |
|           | 3. Administrator confirms the deactivation.                                    |
|           | 4. System indicates that the customer has been deactivated.                    |
| Results:  | Deactivation of customer successful.                                           |

## Activate Customer

| Name:     | Administrator denies to activate customer                                    |
|-----------|------------------------------------------------------------------------------|
| Scenario: | 1.Administrator indicates that the customer "Company X" should be activated. |
|           | 2. System warns the administrator by pointing out that this can be undone.   |
|           | 3. Administrator denies the activation.                                      |
|           | 4. System indicates that the customer has not been activated.                |
| Results:  | Activation of customer not successful.                                       |

| Name:     | Administrator successfully activates customer                                |
|-----------|------------------------------------------------------------------------------|
| Scenario: | 1.Administrator indicates that the customer "Company X" should be activated. |
|           | 2. System warns the administrator by pointing out that this can be undone.   |
|           | 3. Administrator confirms the activation.                                    |
|           | 4. System indicates that the customer has been activated.                    |
| Results:  | Activation of customer successful.                                           |

## View Customer Overview

| Name:     | Administrator views all customers                                 |
|-----------|-------------------------------------------------------------------|
| Scenario: | 1. Administrator indicates he wants to view the general customer overview. |
|           | 2. System displays all the customers with their main information. |
|           | 3. Admin views all the information                                |
| Results:  | Administrator can successfully view the companies.                |

| Name:     | Administrator filters customer        |
|-----------|---------------------------------------------------------------------------------------------|
| Scenario: | 1. Administrator indicates he wants to view the general customer overview. |
|           | 2. System displays all the customers with their main information.     |
|           | 3. Admin indicates he wants to filter the customers.               |
|           | 4. System gives the admin the option to filter the customers based on the fields displayed. |
|           | 5. Admin selects the location filter and only includes company from Venlo.                  |
|           | 6. System displays all the customers located in Venlo, which is only "Company X".           |
| Results:  | Administrator can successfully view the companies based on the filtered criteria.           |

| Name:     | Administrator sorts customers                                                                                                   |
|-----------|---------------------------------------|
| Scenario: | 1. Administrator indicates he wants to view the general customer overview. |
|           | 2. System displays all the customers with their main information.|
|           | 3. Admin indicates he wants to sort the customers.|
|           | 4. System gives the admin the option to sort the customers based on the fields displayed.|
|           | 5. Admin selects the name filter and wants to sort them alphabetically.|
|           | 6. System displays all the customers in alphabetical order, starting with "Aardappelen", then "Brabandse" and then "X Factory". |
| Results:  | Administrator can successfully view the companies based on the sorting criteria.|

## Create Solution

| Name:     | Administrator creates solution with missing data|
|-----------|-----------------------------------------------------------------------------------|
| Scenario: | 1. Administrator indicates that a new Solution needs to be added|
|           | 2. System displays general information form, containing: number, category, title, description, default price, units, number of recurring period, unit of recurring periods, one time payment and VAT rate. |
|           | 3. Administrator fills out "" as number, "product" as category, "Product A" as name and "This product is useful" as description and "1000" as price in Euro, 1 as unit, "3" for number of recurring period and "months" for recurring period unit.                      |
|           | 4. System indicates that the number is missing.|
| Results:  | A new Solution has not been successfully added.|

| Name:     | Administrator creates solution with incorrect data|
|-----------|----------------------------------------------------------------------|
| Scenario: | 1. Administrator indicates that a new Solution needs to be added|
|           | 2. System displays general information form, containing: number, category, title, description, default price, units, number of recurring period, unit of recurring periods, one time payment and VAT rate. |
|           | 3. Administrator fills out "This" as number, "product" as category, "Product A" as name, "This product is useful" as description and "1000" as price in Euro, 1 as unit, "3" for number of recurring period and "months" for recurring period unit.    |
|  | 4. System indicates that the the number format is incorrect. |
| Results:  | A new Solution has not been successfully added.|

| Name:     | Administrator creates solution with already present data|
|-----------|------------------------------------------------------------|
| Scenario: | 1. Administrator indicates that a new Solution needs to be added|
|           | 2. System displays general information form, containing: number, category, title, description, default price, units, number of recurring period, unit of recurring periods, one time payment and VAT rate. |
|           | 3. Administrator fills out "2" as number, "product" as category, "Product A" as name, "This product is useful" as description and "1000" as price in Euro, 1 as unit, "3" for number of recurring period and "months" for recurring period unit.                     |
|  | 4. System indicates that the number is already present in the system. |
| Results:  | A new Solution has not been successfully added.|

| Name:     | Administrator successfully creates solution|
|-----------|--------------------------------------------------------------------------------|
| Scenario: | 1. Administrator indicates that a new Solution needs to be added|
|           | 2. System displays general information form, containing: number, category, title, description, default price, units, number of recurring period, unit of recurring periods, one time payment and VAT rate. |
|           | 3. Administrator fills out "1" as number, "product" as category, "Product A" as name, "This product is useful" as description and "1000" as price in Euro, 1 as unit, "3" for number of recurring period and "months" for recurring period unit.            |
|  | 4. System indicates that the Solution has been saved. |
| Results:  | A new Solution has successfully been added to the database.|

## Read Solution

| Name:     | Administrator reads specific view                                                                |
|-----------|--------------------------------------------------------------------------------------------------|
| Scenario: | 1. System displays the overview page of customer "Company X".                                     |
|           | 2. Administrator clicks on the specific solution "Solution A".                                    |
|           | 3. System opens this specific Solution's page and displays the information to the administrator. |
| Results:  | Administrator can successfully see the overview over "Solution A".                               |

## Update Solution

| Name:     | Administrator updates solution with missing data                                           |
|-----------|--------------------------------------------------------------------------------------------|
| Scenario: | 1. Administrator indicates that the Solution information need to be updated                |
|           | 2. System makes the fields editable                                                        |
|           | 3. Administrator deletes the Solution number and indicates the system to save the changes. |
|           | 4. System indicates that the Solution number is missing.                                   |
| Results:  | The Solution's information did not get altered successfully.                               |

| Name:     | Administrator updates solution with incorrect data                                         |
|-----------|--------------------------------------------------------------------------------------------|
| Scenario: | 1. Administrator indicates that the Solution information need to be updated                |
|           | 2. System makes the fields editable                                                        |
|           | 3. Administrator changes the number to "HEY" and indicates the system to save the changes. |
|           | 4. System indicates that the Solution number is incorrect.                                 |
| Results:  | The Solution's information did not get altered successfully.                               |

| Name:     | Administrator update solution with already existing data                                          |
|-----------|---------------------------------------------------------------------------------------------------|
| Scenario: | 1. Administrator indicates that the Solution information need to be updated                       |
|           | 2. System makes the fields editable                                                               |
|           | 3. Administrator changes the Solution number to "2" and indicates the system to save the changes. |
|           | 4. System indicates that the Solution number is already present in the system.                    |
| Results:  | The Solution's information did not get altered successfully.                                      |

| Name:     | Administrator successfully updates solution                                                            |
|-----------|--------------------------------------------------------------------------------------------------------|
| Scenario: | 1. Administrator indicates that the Solution information need to be updated                            |
|           | 2. System makes the fields editable                                                                    |
|           | 3. Administrator makes changes the name to "Solution A1" and indicates the system to save the changes. |
|           | 4. System indicates that the Solution has been saved.                                                  |
| Results:  | The Solution's information got altered successfully.                                                   |

## Delete Solution                                                                

| Name:     | Administrator tries to delete an assigned Solution                                    |
|-----------|------------------------------------------------------------------------------|
| Scenario: | 1.Administrator indicates that the Solution "Solution A" should be deleted.  |
|           | 2. System indicates that "Solution A" is still assigned to a customer and therefore cannot be deleted. |
| Results:  | Solution was not successfully deleted.      

| Name:     | Administrator denies deletion of Solution                                    |
|-----------|------------------------------------------------------------------------------|
| Scenario: | 1.Administrator indicates that the Solution "Solution A" should be deleted.  |
|           | 2. System warns the administrator by pointing out that this can't be undone. |
|           | 3. Administrator denies the deletion.                                        |
|           | 4. System indicates that the Solution "Solution A" has not been deleted.     |
| Results:  | Solution was not successfully deleted.                                       |

| Name:     | Administrator approves deletion of Solution                                                            |
|-----------|--------------------------------------------------------------------------------------------------------|
| Scenario: | 1.Administrator indicates that the Solution "Solution A" should be deleted.                            |
|           | 2. System warns the administrator by pointing out that this can't be undone.                           |
|           | 3. Administrator confirms the deletion.                                                                |
|           | 4. System indicates that the Solution "Solution A" has been deleted, with all the information present. |
| Results:  | Solution was successfully deleted.     

## View Solution Overview 

| Name:     | Administrator views all solutions                                 |
|-----------|-------------------------------------------------------------------|
| Scenario: | 1. Administrator indicates he wants to view the general solution overview. |
|           | 2. System displays all the solutions with their main information. |
|           | 3. Admin views all the information                                |
| Results:  | Administrator can successfully view the solutions.                |

| Name:     | Administrator filters solution        |
|-----------|---------------------------------------------------------------------------------------------|
| Scenario: | 1. Administrator indicates he wants to view the general solution overview. |
|           | 2. System displays all the solutions with their main information.     |
|           | 3. Admin indicates he wants to filter the solutions.               |
|           | 4. System gives the admin the option to filter the solutions based on the fields displayed. |
|           | 5. Admin selects the category and filters for only the "serivces".                  |
|           | 6. System displays all solutions that are "serivces".           |
| Results:  | Administrator can successfully view the solutions based on the filtered criteria.           |

| Name:     | Administrator sorts customers                                                                                                   |
|-----------|---------------------------------------|
| Scenario: | 1. Administrator indicates he wants to view the general solution overview. |
|           | 2. System displays all the solutions with their main information.|
|           | 3. Admin indicates he wants to sort the solutions.|
|           | 4. System gives the admin the option to sort the solutions based on the fields displayed.|
|           | 5. Admin selects the name filter and wants to sort them alphabetically.|
|           | 6. System displays all the solutions in alphabetical order, starting with "Product A", then "Service B" and then "Software-Task A". |
| Results:  | Administrator can successfully view the companies based on the sorting criteria.|

## Assign Solution

| Name:     | Administrator assigns a solution to a customer with missing information                               |
|-----------|--------------------------------------------------------------------------------|
| Scenario: | 1. Administrator Administrator indicates that a solution needs to be assigned to the Customer "Company X". |           
|           | 2. System displays a list of available solutions.|            
|           | 3. Administrator selects "Solution A".|
|			      | 4. System displays additional price information: price, units, recurring period, unit of recurring periods, one time payment, VAT rate, start and end date. |
|           | 5. Administrator deletes the default units for the solution, then fills out "1000" as price, "" as units, "3" as recurring period, "year" as unit of recurring period, doesn't select "One-Time-Payment", "0.12" as VAT-rate, "01.01.2024" as start date and "01.01.2026" as end date and saves it.|
|			| 6. System indicates that the units field is empty.|
| Results:  | Solution A has not been assigned successfully to Company X.|

| Name:     | Administrator assigns a solution to a customer with invalid informatio                                |
|-----------|--------------------------------------------------------------------------------|
| Scenario: | 1. Administrator Administrator indicates that a solution needs to be assigned to a customer. |           
|           | 2. System displays a list of available solutions.|            
|           | 3. Administrator selects "Solution A".|
|			| 4. System displays additional price information: price, units, recurring period, unit of recurring periods, one time payment, VAT rate, start and end date. |
|           | 5. Administrator fills out "I don't know?????" as price, "1" as units, "3" as recurring period, "year" as unit of recurring period, doesn't select "One-Time-Payment", "0.12" as VAT-rate, "01.01.2024" as start date and "01.01.2026" as end date and saves it.|
|			| 6. System indicates that the field "price" is incorrectly filled.|
| Results:  | Solution A has not been assigned successfully to Company X.|

| Name:     | Administrator assigns a solution to a customer sucessfully                               |
|-----------|--------------------------------------------------------------------------------|
| Scenario: | 1. Administrator Administrator indicates that a solution needs to be assigned to a customer. |           
|           | 2. System displays a list of available solutions.|            
|           | 3. Administrator selects "Solution A".|
|			| 4. System displays additional price information: price, units, recurring period, unit of recurring periods, one time payment, VAT rate, start and end date. |
|           | 5. Administrator fills out "1000" as price, "1" as units, "3" as recurring period, "year" as unit of recurring period, doesn't select "One-Time-Payment", "0.12" as VAT-rate, "01.01.2024" as start date and "01.01.2026" as end date and saves it.|
|			| 6. System associates the solution with the customer.|
| Results:  | Solution A is successfully assigned to Company X.|

| Name:     | Administrator assigns a solution to a customer (without price) sucessfully                                 |
|-----------|--------------------------------------------------------------------------------|
| Scenario: | 1. Administrator Administrator indicates that a solution needs to be assigned to the Customer "Company X". |           
|           | 2. System displays a list of available solutions.|            
|           | 3. Administrator selects "Solution A".|
|			| 4. System displays additional price information: price, units, recurring period, unit of recurring periods, one time payment, VAT rate, start and end date. |
|           | 5. Administrator fills out "" as price, "1" as units, "3" as recurring period, "year" as unit of recurring period, doesn't select "One-Time-Payment", "0.12" as VAT-rate, "01.01.2024" as start date and "01.01.2026" as end date and saves it.|
|			| 6. System indicates that the solution has been associated with the customer (default price is used).|
| Results:  | Solution A has  been assigned successfully to Company X.|

## Unassign Solution from Customer

| Name:     | Administrator attempts to unassign an unassigned solution from a customer        |
|-----------|--------------------------------------------------------------------------------|
| Scenario: | 1. Administrator indicates that the solution "Product A" should be unassigned from a customer.   |          
|           | 2. System asks for confirmation of the unassignment. |					
|           | 3. Administrator denies the unassignment.             |
|           | 4. System indicates that the solution is still assigned to the customer.             |
| Results:  | "Product A" is unsuccessfully unassigned from Company X.|

| Name:     | Administrator unassigns a solution from a customer                             |
|-----------|--------------------------------------------------------------------------------|
| Scenario: | 1. Administrator indicates that the solution "Product A" should be unassigned from a customer.   |          
|           | 2. System asks for confirmation of the unassignment. |					
|           | 3. Administrator confirms the unassignment.             |
|           | 4. System disassociates the solution from the customer.             |
| Results:  | "Product A" is successfully unassigned from Company X.|


## Create Contact Person

| Name:     | Administrator creates Contact Person with missing data|
|-----------|---------------------------------------------------------|
| Scenario: | 1. Administrator indicates that a new contact person needs to be added|
|           | 2. System displays general information form, containing: Last Name, First Name, Middle name(s), email(unique), phone number, Function/ Role, description (relational)|
|           | 3. Administrator fills in "" as last name, "Hans" as first name, no middle name, hanspeter@gmail.com" as mail, "+31 4323432123" as phone number, "Lead Developer" as Function and no description. |
|           | 4. System indicates that the contact person is missing the last name.|
| Results:  | Adding the Contact Person was not successful.|

| Name:     | Administrator creates Contact Person with incorrect data|
|-----------|------------------------------------------------------------|
| Scenario: | 1. Administrator indicates that a new contact person needs to be added|
|           | 2. System displays general information form, containing: Last Name, First Name, Middle name(s), email(unique), phone number, Function/ Role, description (relational)|
|           | 3. Administrator fills in "1234" as last name, "Hans" as first name, no middle name, hanspeter@gmail.com" as mail, "+31 4323432123" as phone number, "Lead Developer" as Function and no description. |
|           | 4. System indicates that the contact person's last name is incorrect.|
| Results:  | Adding the Contact Person was not successful.|

| Name:     | Administrator creates Contact Person with already present data|
|-----------|-----------------------------------------------------------------|
| Scenario: | 1. Administrator indicates that a new contact person needs to be added|
|           | 2. System displays general information form, containing: Last Name, First Name, Middle name(s), email(unique), phone number, Function/ Role, description (relational)                                  |
|           | 3. Administrator fills in "Peter" as last name, "Hans" as first name, no middle name, karlheinz@gmail.com" as mail, "+31 4323432123" as phone number, "Lead Developer" as Function and no description. |
|           | 4. System indicates that the contact person'S mail is already present in the system.|
| Results:  | Adding the Contact Person was not successful.|

| Name:     | Administrator creates Contact Person|
|-----------|--------------------------------------------------------------------|
| Scenario: | 1. Administrator indicates that a new contact person needs to be added|
|           | 2. System displays general information form, containing: Last Name, First Name, Middle name(s), email(unique), phone number, Function/ Role, description (relational)                          |
|           | 3. Administrator fills in "Hans" as last name, "Hans" as first name, no middle name, hanspeter@gmail.com" as mail, "+31 4323432123" as phone number, "Lead Developer" as Function and no description. |
|           | 4. System indicates that the contact person was successfully added.|
| Results:  | Adding the Contact Person was successful.|

## Read Contact Person

| Name:     | Actor logs in with invalid combination of email and password                                   |
|-----------|------------------------------------------------------------------------------------------------|
| Scenario: | 1. System displays the customer's page.                                                        |
|           | 2. Administrator indicates he wants to view the information of "Hans Peter".                   |
|           | 3. System opens this specific person's page and displays the information to the administrator. |
| Results:  | Administrator can see a "Hans Peter's" information                                             |

## Update Person

| Name:     | Administrator updates Contact Person with missing data                               |
|-----------|--------------------------------------------------------------------------------------|
| Scenario: | 1. Administrator indicates that the contact person's information need to be updated  |
|           | 2. System makes the fields editable                                                  |
|           | 3. Administrator deletes the last name and indicates the system to save the changes. |
|           | 4. System indicates that the contact person is missing the last name.                |
| Results:  | The contact person's information did not get altered successfully.                   |

| Name:     | Administrator updates Contact Person with incorrect data                                             |
|-----------|------------------------------------------------------------------------------------------------------|
| Scenario: | 1. Administrator indicates that the contact person's information need to be updated                  |
|           | 2. System makes the fields editable                                                                  |
|           | 3. Administrator changes the first name to "112121212" and indicates the system to save the changes. |
|           | 4. System indicates that the contact person has an incorrect first name.                             |
| Results:  | The contact person's information did not get altered successfully.                                   |

| Name:     | Administrator updates Contact Person with already present data|
|-----------|-----------------------------------------------------|
| Scenario: | 1. Administrator indicates that the contact person's information need to be updated|
|           | 2. System makes the fields editable|
|           | 3. Administrator updates the mail address to "karlheinz@gmail.com" and indicates the system to save the changes. |
|           | 4. System indicates that the mail address is already present in the system.|
| Results:  | The contact person's information did not get altered successfully.        |

| Name:     | Administrator updates Contact Person successfully                                            |
|-----------|----------------------------------------------------------------------------------------------|
| Scenario: | 1. Administrator indicates that the contact person's information need to be updated          |
|           | 2. System makes the fields editable                                                          |
|           | 3. Administrator adds the middle name "Günter" and indicates the system to save the changes. |
|           | 4. System indicates that the contact person has been saved.                                  |
| Results:  | The contact person's information got altered successfully.                                   |

## Delete Contact Person

| Name:     | Administrator denies the deletion of the Contact Person                           |
|-----------|-----------------------------------------------------------------------------------|
| Scenario: | 1.Administrator indicates that the contact person "Hans Peter" should be deleted. |
|           | 2. System warns the administrator by pointing out that this can't be undone.      |
|           | 3. Administrator denies the deletion.                                             |
|           | 4. System indicates that the Contact Person has not been deleted.                 |
| Results:  | Contact Person was not successfully deleted.                                      |

| Name:     | Administrator approves the deletion of the Contact Person                                       |
|-----------|-------------------------------------------------------------------------------------------------|
| Scenario: | 1.Administrator indicates that the contact person "Hans Peter" should be deleted.               |
|           | 2. System warns the administrator by pointing out that this can't be undone.                    |
|           | 3. Administrator confirms the deletion.                                                         |
|           | 4. System indicates that the Contact Person has been deleted, with all the information present. |
| Results:  | Contact Person was successfully deleted.                                                        |

## Use Case(s) Ticket System

### Assign GitLab Project
| Name: | Cancellation of Assignment of GitLab Project |
|----|----|
| Actor: | Administrator |
| Scenario: |1. Administrator indicates that a GitLab project needs to be assigned to a customer.  |
|  | 2. System displays a list(dropdown) of all available GitLab projects of AppComm.  |
|  | 3. Administrator selects the GitLab project "Project1" and then indicates to cancel the process. |
|  | 4. System stops the process and does not associates the GitLab project with the customer. |
| Results: | GitLab project was not successfully assigned to a customer.|

| Name: | Successfully Assigning GitLab Project |
|----|----|
| Actor: | Administrator |
| Description: | Administrator wants to assign a GitLab project to a customer |
| Pre-condition: | Administrator is on the overview page of a specific customer |
| Scenario: |1. Administrator indicates that a GitLab project needs to be assigned to a customer.  |
|  | 2. System displays a list(dropdown) of all available GitLab projects of AppComm.  |
|  | 3. Administrator selects the GitLab project "Project1" and indicates to assign it. |
|  | 4. System associates the GitLab project with the customer. |
| Results: | GitLab project was successfully assigned to a customer.|


### Unassign GitLab Project

| Name: | Cancellation of Unassigning GitLab Project |
|----|----|
| Actor: | Administrator |
| Scenario: |1. Administrator indicates a specific GitLab project should be unassigned from a customer. |
|  | 2. System asks for confirmation of the unassignment.  |
|  | 3. Administrator denies the unassignment. |
|  | 4. System does not disassociate the GitLab project from the customer. |
| Results: | The GitLab project has not been successfully unassigned from the customer.|

| Name: | Successfully Unassign GitLab Project |
|----|----|
| Actor: | Administrator |
| Scenario: |1. Administrator indicates a specific GitLab project should be unassigned from a customer. |
|  | 2. System asks for confirmation of the unassignment.  |
|  | 3. Administrator confirms the unassignment. |
|  | 4. System disassociates the GitLab project from the customer. |
| Results: | The GitLab project has been successfully unassigned from the customer.|

### Write Ticket

| Name: | Ticket is not created due to missing input |
|----|----|
| Actor: | Administrator |
| Scenario: |1. Administrator indicates a new ticket should be created in GitLab. |
|  | 2. Sytem displays a form with a title, a category and a description.  |
|  | 3. Administrator fills in "Fix Bug UI - 8" for the title, "Correct number of entries" as description and saves the ticket. |
|  | 4. System indicates that the ticket was not created since the category was not selected. |
| Results: | Ticket was not succesfully created.|


| Name: | Ticket is not created due to missing input |
| --------- | -------------------------------------------------- |
| Actor: | Administrator |
| Description: | Administrator wants to add a new ticket via GitLab |
| Scenario: |1. Administrator indicates a new ticket should be created in GitLab. |
|  | 2. Sytem displays a form with a title, a category and a description.  |
|  | 3. Administrator fills in "Fix Bug UI - 8" for the title, "Correct number of entries" as description, selects "Bug" as category and saves the ticket. |
|  | 4. System indicates that the ticket was created in GitLab. |
| Results: | Ticket was succesfully created.|

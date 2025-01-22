# Inventory Management System

## Project Overview
The **Inventory Management System** is designed to simulate and manage procedure codes and inventory levels in a healthcare setting. It is built using **Vue.js** for the frontend, **Laravel** for the backend, and **PostgreSQL** as the database.

The system allows administrators to manage procedure code mappings, automate inventory deductions based on predefined templates, and visualize inventory trends and levels.

---

## **Technologies Used**
- **Frontend**: Vue 3, Vue Router, Pinia (State Management), VeeValidate, Bootstrap, CoreUI, CKEditor, SweetAlert2
- **Backend**: Laravel (PHP Framework)
- **Database**: PostgreSQL
- **Build Tools**: Vite, Axios
- **Charting**: ApexCharts, DataTables

---

## **Features**
1. **Mock Procedure Code Retrieval**
   - Simulates the retrieval of procedure codes from a mock dataset.
2. **Procedure Code Mapping Interface**
   - Allows mapping of procedure codes to predefined templates.
3. **Automated Inventory Deduction**
   - Matches selected procedure codes to templates and deducts inventory items.
4. **Error Handling & Logging**
   - Logs missing codes and insufficient stock issues.
5. **Basic Inventory Dashboard**
   - Displays current inventory levels, low stock alerts, and usage trends.

---

## **Features Walkthrough**

### **1. Mock Procedure Code Retrieval**
The system simulates the retrieval of procedure codes from a local mock dataset. Sample procedure codes include:
- `D3310` (Root Canal Treatment)
- `D2331` (Tooth Filling)

The data can be fetched and displayed in the Vue.js frontend via API requests. The mock dataset can be updated or expanded as needed.

### **2. Procedure Code Mapping**
Admins have the ability to map procedure codes to predefined templates. For example:
- `D3310` → Root Canal (Lidocaine: 2 units, Gutta-percha: 1 unit)

This simple mapping interface allows administrators to add, edit, and delete mappings, providing flexibility in managing the mappings based on real-life procedures.

### **3. Automated Inventory Deduction**
When a procedure code is selected:
- The system automatically matches the procedure code to a predefined template.
- Based on this mapping, the relevant items such as `Lidocaine` and `Gutta-percha` are deducted from the inventory.
- A confirmation screen is shown, listing the items and quantities to be deducted.
- Administrators can adjust quantities or switch brands before finalizing the deduction, ensuring accurate inventory tracking.

### **4. Error Handling**
The system implements robust error handling:
- **Missing or Unmapped Procedure Codes**: If a selected procedure code is not mapped, it is logged for admin review.
- **Insufficient Stock**: If there is insufficient stock to complete a deduction, a prompt is displayed, and alternative items are suggested.
- **Logging**: All actions such as deductions, adjustments, and errors are logged for auditing purposes. This ensures transparency and accountability.

### **5. Basic Inventory Dashboard**
The inventory dashboard provides essential functionality to monitor inventory:
- **Inventory Levels**: The dashboard displays the current stock levels for key items like `Lidocaine` and `Gutta-percha`.
- **Low Stock Alerts**: When stock levels fall below a predefined threshold, items are flagged with a "low stock" message (e.g., "Lidocaine: 5 units remaining").
- **Restock Now**: The dashboard includes a "Restock Now" button, which simulates restocking of the inventory.
- **Usage Trends**: A bar chart is used to display usage trends for top inventory items over the past 7 days, helping administrators monitor which items are most frequently used.

---

## **Screenshots**
Include screenshots of key pages in your project, such as:
- Procedure Code Mapping Interface
- Inventory Deduction Confirmation
- Inventory Dashboard

---

## **Development Notes**
- **State Management**: The application uses **Pinia** for state management, ensuring smooth state transitions across the app.
- **API Requests**: **Axios** is used to make API calls to the Laravel backend for retrieving data, submitting forms, and processing requests.
- **Charting**: **ApexCharts** is used for visualizing inventory trends and usage statistics.
- **Validation**: **VeeValidate** ensures that form inputs, such as procedure codes, are properly validated.

---

## **Scripts**
The following npm scripts are available for managing the frontend:

- **Development Mode**:
  ```bash
  npm run dev
Starts the development server with hot reloading.

- **Build Production**:
  ```bash
  npm run build
Builds the project for production.

## **Contributing**
We welcome contributions! If you'd like to help improve this project, please fork the repository, create a new branch, and submit a pull request with your changes.

## **License**
This project is licensed under the MIT License - see the LICENSE file for details.

## **Installation Setup**
### **1. Clone the repository**
- Start by cloning the repository to your local machine:
  ```bash
  git clone https://github.com/your-username/inventory-management.git
  cd inventory-management

### **2. Install Backend (Laravel) Dependencies**
- Navigate to the backend folder and install the necessary Laravel dependencies:
  ```bash
  cd backend
  composer install
  php artisan key:generate

### **3. Install Frontend (Vue.js) Dependencies**
- Navigate to the frontend folder and install the Vue.js dependencies:
  ```bash
  cd frontend
  npm install

### **4. Configure the Database**
- Make sure your PostgreSQL database is set up and the connection is configured in the .env file. Update the database settings as needed:
  ```bash
  DB_CONNECTION=pgsql
  DB_HOST=127.0.0.1
  DB_PORT=5432
  DB_DATABASE=your_database_name
  DB_USERNAME=your_username
  DB_PASSWORD=your_password
- Run the migrations to set up the necessary tables in the database:
  ```bash
  php artisan migrate

### **5. Run the Development Server**
- To start the development servers for both backend and frontend:
- **Backend (Laravel):**
  ```bash
  php artisan serve

- **Frontend (Vue.js with Vite):**
  ```bash
  npm run dev


